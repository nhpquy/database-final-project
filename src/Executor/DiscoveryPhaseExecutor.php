<?php


namespace FinalProject\RecommendationEngine\Executor;

use FinalProject\RecommendationEngine\Context\Context;
use FinalProject\RecommendationEngine\Persistence\DatabaseService;
use GraphAware\Common\Type\Node;

class DiscoveryPhaseExecutor
{
    /**
     * @var \FinalProject\RecommendationEngine\Persistence\DatabaseService
     */
    private $databaseService;

    /**
     * DiscoveryPhaseExecutor constructor.
     *
     * @param \FinalProject\RecommendationEngine\Persistence\DatabaseService $databaseService
     */
    public function __construct(DatabaseService $databaseService)
    {
        $this->databaseService = $databaseService;
    }

    /**
     * @param Node $input
     * @param \FinalProject\RecommendationEngine\Engine\DiscoveryEngine[] $engines
     * @param \FinalProject\RecommendationEngine\Filter\BlackListBuilder[] $blacklists
     * @param Context $context
     *
     * @return \GraphAware\Common\Result\ResultCollection
     */
    public function processDiscovery(Node $input, array $engines, array $blacklists, Context $context)
    {
        $stack = $this->databaseService->getDriver()->stack();
        foreach ($engines as $engine) {
            $statement = $engine->discoveryQuery($input, $context);
            $stack->push($statement->text(), $statement->parameters(), $engine->name());
        }

        foreach ($blacklists as $blacklist) {
            $statement = $blacklist->blacklistQuery($input);
            $stack->push($statement->text(), $statement->parameters(), $blacklist->name());
        }

        try {
            $resultCollection = $this->databaseService->getDriver()->runStack($stack);

            return $resultCollection;
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }
}
