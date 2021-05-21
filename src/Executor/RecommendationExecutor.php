<?php


namespace FinalProject\RecommendationEngine\Executor;

use FinalProject\RecommendationEngine\Context\Context;
use FinalProject\RecommendationEngine\Engine\RecommendationEngine;
use FinalProject\RecommendationEngine\Persistence\DatabaseService;
use FinalProject\RecommendationEngine\Result\Recommendations;
use GraphAware\Common\Result\ResultCollection;
use GraphAware\Common\Type\Node;
use Symfony\Component\Stopwatch\Stopwatch;

class RecommendationExecutor
{
    /**
     * @var \FinalProject\RecommendationEngine\Executor\DiscoveryPhaseExecutor
     */
    protected $discoveryExecutor;

    /**
     * @var \FinalProject\RecommendationEngine\Executor\PostProcessPhaseExecutor
     */
    protected $postProcessExecutor;
    /**
     * @var \Symfony\Component\Stopwatch\Stopwatch
     */
    protected $stopwatch;

    public function __construct(DatabaseService $databaseService)
    {
        $this->discoveryExecutor = new DiscoveryPhaseExecutor($databaseService);
        $this->postProcessExecutor = new PostProcessPhaseExecutor($databaseService);
        $this->stopwatch = new Stopwatch();
    }

    public function processRecommendation(Node $input, RecommendationEngine $engine, Context $context): Recommendations
    {
        $recommendations = $this->doDiscovery($input, $engine, $context);
        $this->doPostProcess($input, $recommendations, $engine);
        $recommendations->sort();

        return $recommendations;
    }

    private function doDiscovery(Node $input, RecommendationEngine $engine, Context $context): Recommendations
    {
        $recommendations = new Recommendations($context);
        $context->getStatistics()->startDiscovery();
        $result = $this->discoveryExecutor->processDiscovery(
            $input,
            $engine->getDiscoveryEngines(),
            $engine->getBlacklistBuilders(),
            $context
        );

        foreach ($engine->getDiscoveryEngines() as $discoveryEngine) {
            $recommendations->merge($discoveryEngine->produceRecommendations($input, $result, $context));
        }
        $context->getStatistics()->stopDiscovery();

        $blacklist = $this->buildBlacklistedNodes($result, $engine);
        $this->removeIrrelevant($input, $engine, $recommendations, $blacklist);

        return $recommendations;
    }

    private function doPostProcess(Node $input, Recommendations $recommendations, RecommendationEngine $engine)
    {
        $recommendations->getContext()->getStatistics()->startPostProcess();
        $postProcessResult = $this->postProcessExecutor->execute($input, $recommendations, $engine);
        foreach ($engine->getPostProcessors() as $postProcessor) {
            $tag = $postProcessor->name();
            $result = $postProcessResult->get($tag);
            $postProcessor->handleResultSet($input, $result, $recommendations);
        }
        $recommendations->getContext()->getStatistics()->stopPostProcess();
    }

    private function removeIrrelevant(Node $input, RecommendationEngine $engine, Recommendations $recommendations, array $blacklist)
    {
        foreach ($recommendations->getItems() as $recommendation) {
            if (array_key_exists($recommendation->item()->identity(), $blacklist)) {
                $recommendations->remove($recommendation);
            } else {
                foreach ($engine->filters() as $filter) {
                    if (!$filter->doInclude($input, $recommendation->item())) {
                        $recommendations->remove($recommendation);
                        break;
                    }
                }
            }
        }
    }

    private function buildBlacklistedNodes(ResultCollection $result, RecommendationEngine $engine)
    {
        $set = [];
        foreach ($engine->getBlacklistBuilders() as $blacklist) {
            $res = $result->get($blacklist->name());
            foreach ($res->records() as $record) {
                if ($record->hasValue($blacklist->itemResultName())) {
                    $node = $record->get($blacklist->itemResultName());
                    if ($node instanceof Node) {
                        $set[$node->identity()] = $node;
                    }
                }
            }
        }

        return $set;
    }
}
