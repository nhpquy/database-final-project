<?php


namespace FinalProject\RecommendationEngine\Executor;

use Exception;
use FinalProject\RecommendationEngine\Engine\RecommendationEngine;
use FinalProject\RecommendationEngine\Persistence\DatabaseService;
use FinalProject\RecommendationEngine\Post\CypherAwarePostProcessor;
use FinalProject\RecommendationEngine\Post\RecommendationSetPostProcessor;
use FinalProject\RecommendationEngine\Result\Recommendations;
use GraphAware\Common\Type\Node;
use RuntimeException;

class PostProcessPhaseExecutor
{
    /**
     * @var \FinalProject\RecommendationEngine\Persistence\DatabaseService
     */
    protected $databaseService;

    /**
     * PostProcessPhaseExecutor constructor.
     *
     * @param \FinalProject\RecommendationEngine\Persistence\DatabaseService $databaseService
     */
    public function __construct(DatabaseService $databaseService)
    {
        $this->databaseService = $databaseService;
    }

    /**
     * @param \GraphAware\Common\Type\Node $input
     * @param \FinalProject\RecommendationEngine\Result\Recommendations $recommendations
     * @param \FinalProject\RecommendationEngine\Engine\RecommendationEngine $recommendationEngine
     *
     * @return \GraphAware\Common\Result\ResultCollection
     */
    public function execute(Node $input, Recommendations $recommendations, RecommendationEngine $recommendationEngine)
    {
        $stack = $this->databaseService->getDriver()->stack('post_process_' . $recommendationEngine->name());

        foreach ($recommendationEngine->getPostProcessors() as $postProcessor) {
            if ($postProcessor instanceof CypherAwarePostProcessor) {
                foreach ($recommendations->getItems() as $recommendation) {
                    $tag = sprintf('post_process_%s_%d', $postProcessor->name(), $recommendation->item()->identity());
                    $statement = $postProcessor->buildQuery($input, $recommendation);
                    $stack->push($statement->text(), $statement->parameters(), $tag);
                }
            } elseif ($postProcessor instanceof RecommendationSetPostProcessor) {
                $statement = $postProcessor->buildQuery($input, $recommendations);
                $stack->push($statement->text(), $statement->parameters(), $postProcessor->name());
            }
        }

        try {
            return $this->databaseService->getDriver()->runStack($stack);
        } catch (Exception $e) {
            throw new RuntimeException('PostProcess Query Exception - ' . $e->getMessage());
        }
    }
}
