<?php


namespace FinalProject\RecommendationEngine\Engine;

use FinalProject\RecommendationEngine\Context\Context;
use FinalProject\RecommendationEngine\Persistence\DatabaseService;
use FinalProject\RecommendationEngine\Result\Recommendations;
use GraphAware\Common\Type\Node;

interface RecommendationEngine
{
    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return \FinalProject\RecommendationEngine\Engine\DiscoveryEngine[]
     */
    public function discoveryEngines(): array;

    /**
     * @return \FinalProject\RecommendationEngine\Filter\BlackListBuilder[]
     */
    public function blacklistBuilders(): array;

    /**
     * @return \FinalProject\RecommendationEngine\Post\PostProcessor[]
     */
    public function postProcessors(): array;

    /**
     * @return \FinalProject\RecommendationEngine\Filter\Filter[]
     */
    public function filters(): array;

    /**
     * @return \Psr\Log\LoggerInterface[]
     */
    public function loggers(): array;

    /**
     * @return \FinalProject\RecommendationEngine\Engine\DiscoveryEngine[]
     */
    public function getDiscoveryEngines(): array;

    /**
     * @return \FinalProject\RecommendationEngine\Filter\BlackListBuilder[]
     */
    public function getBlacklistBuilders(): array;

    /**
     * @return \FinalProject\RecommendationEngine\Filter\Filter[]
     */
    public function getFilters(): array;

    /**
     * @return \FinalProject\RecommendationEngine\Post\PostProcessor[]
     */
    public function getPostProcessors(): array;

    /**
     * @return \Psr\Log\LoggerInterface[]
     */
    public function getLoggers(): array;

    /**
     * @param Node $input
     * @param Context $context
     *
     * @return \FinalProject\RecommendationEngine\Result\Recommendations
     */
    public function recommend(Node $input, Context $context): Recommendations;

    /**
     * @param \FinalProject\RecommendationEngine\Persistence\DatabaseService $databaseService
     */
    public function setDatabaseService(DatabaseService $databaseService);
}
