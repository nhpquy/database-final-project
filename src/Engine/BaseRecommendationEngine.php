<?php

declare (strict_types=1);


namespace FinalProject\RecommendationEngine\Engine;

use FinalProject\RecommendationEngine\Context\Context;
use FinalProject\RecommendationEngine\Executor\RecommendationExecutor;
use FinalProject\RecommendationEngine\Filter\BlackListBuilder;
use FinalProject\RecommendationEngine\Filter\Filter;
use FinalProject\RecommendationEngine\Persistence\DatabaseService;
use FinalProject\RecommendationEngine\Post\PostProcessor;
use FinalProject\RecommendationEngine\Result\Recommendations;
use GraphAware\Common\Type\Node;
use Psr\Log\LoggerInterface;

abstract class BaseRecommendationEngine implements RecommendationEngine
{
    /**
     * @var \FinalProject\RecommendationEngine\Persistence\DatabaseService
     */
    private $databaseService;

    /**
     * @var \FinalProject\RecommendationEngine\Executor\RecommendationExecutor
     */
    private $recommendationExecutor;

    /**
     * {@inheritdoc}
     */
    public function discoveryEngines(): array
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function blacklistBuilders(): array
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function filters(): array
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function postProcessors(): array
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function loggers(): array
    {
        return array();
    }

    /**
     * @return \FinalProject\RecommendationEngine\Engine\DiscoveryEngine[]
     */
    final public function getDiscoveryEngines(): array
    {
        return array_filter($this->discoveryEngines(), function (DiscoveryEngine $discoveryEngine) {
            return true;
        });
    }

    /**
     * @return \FinalProject\RecommendationEngine\Filter\BlackListBuilder[]
     */
    final public function getBlacklistBuilders(): array
    {
        return array_filter($this->blacklistBuilders(), function (BlackListBuilder $blackListBuilder) {
            return true;
        });
    }

    /**
     * @return \FinalProject\RecommendationEngine\Filter\Filter[]
     */
    final public function getFilters(): array
    {
        return array_filter($this->filters(), function (Filter $filter) {
            return true;
        });
    }

    /**
     * @return \FinalProject\RecommendationEngine\Post\PostProcessor[]
     */
    final public function getPostProcessors(): array
    {
        return array_filter($this->postProcessors(), function (PostProcessor $postProcessor) {
            return true;
        });
    }

    /**
     * @return array|\Psr\Log\LoggerInterface[]
     */
    final public function getLoggers(): array
    {
        return array_filter($this->loggers(), function (LoggerInterface $logger) {
            return true;
        });
    }

    /**
     * @param Node $input
     * @param Context $context
     *
     * @return \FinalProject\RecommendationEngine\Result\Recommendations
     */
    final public function recommend(Node $input, Context $context): Recommendations
    {
        $recommendations = $this->recommendationExecutor->processRecommendation($input, $this, $context);

        return $recommendations;
    }

    final public function setDatabaseService(DatabaseService $databaseService)
    {
        $this->databaseService = $databaseService;
        $this->recommendationExecutor = new RecommendationExecutor($this->databaseService);
    }
}
