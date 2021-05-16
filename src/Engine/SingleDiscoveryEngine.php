<?php

declare (strict_types=1);


namespace FinalProject\RecommendationEngine\Engine;

use FinalProject\RecommendationEngine\Context\Context;
use FinalProject\RecommendationEngine\Result\Recommendations;
use FinalProject\RecommendationEngine\Result\SingleScore;
use GraphAware\Common\Result\Record;
use GraphAware\Common\Result\ResultCollection;
use GraphAware\Common\Type\Node;

abstract class SingleDiscoveryEngine implements DiscoveryEngine
{
    private static $DEFAULT_RECO_NAME = 'reco';
    private static $DEFAULT_SCORE_NAME = 'score';
    private static $DEFAULT_REASON_NAME = 'reason';

    /**
     * {@inheritdoc}
     *
     * @param Node $input
     * @param Node $item
     * @param Record $record
     * @param Context $context
     *
     * @return \FinalProject\RecommendationEngine\Result\SingleScore
     */
    public function buildScore(Node $input, Node $item, Record $record, Context $context): SingleScore
    {
        $score = $record->hasValue($this->scoreResultName()) ? $record->value($this->scoreResultName()) : $this->defaultScore();
        $reason = $record->hasValue($this->reasonResultName()) ? $record->value($this->reasonResultName()) : null;

        return new SingleScore($score, $reason);
    }

    /**
     * {@inheritdoc}
     *
     * @param Node $input
     * @param ResultCollection $resultCollection
     * @param Context $context
     *
     * @return \FinalProject\RecommendationEngine\Result\Recommendations
     */
    final public function produceRecommendations(Node $input, ResultCollection $resultCollection, Context $context): Recommendations
    {
        $result = $resultCollection->get($this->name());
        $recommendations = new Recommendations($context);

        foreach ($result->records() as $record) {
            if ($record->hasValue($this->recoResultName())) {
                $recommendations->add($record->get($this->recoResultName()), $this->name(), $this->buildScore($input, $record->get($this->recoResultName()), $record, $context));
            }
        }

        return $recommendations;
    }

    /**
     * {@inheritdoc}
     */
    public function recoResultName(): string
    {
        return self::$DEFAULT_RECO_NAME;
    }

    /**
     * {@inheritdoc}
     */
    public function scoreResultName(): string
    {
        return self::$DEFAULT_SCORE_NAME;
    }

    /**
     * {@inheritdoc}
     */
    public function reasonResultName(): string
    {
        return self::$DEFAULT_REASON_NAME;
    }

    /**
     * {@inheritdoc}
     */
    public function defaultScore(): float
    {
        return 1.0;
    }
}
