<?php


namespace FinalProject\RecommendationEngine\Post;

use FinalProject\RecommendationEngine\Result\Recommendation;
use FinalProject\RecommendationEngine\Result\Recommendations;
use GraphAware\Common\Result\Record;
use GraphAware\Common\Result\Result;
use GraphAware\Common\Type\Node;

abstract class RecommendationSetPostProcessor implements PostProcessor
{
    /**
     * @param \GraphAware\Common\Type\Node $input
     * @param \FinalProject\RecommendationEngine\Result\Recommendations $recommendations
     *
     * @return \GraphAware\Common\Cypher\Statement
     */
    abstract public function buildQuery(Node $input, Recommendations $recommendations);

    abstract public function postProcess(Node $input, Recommendation $recommendation, Record $record);

    final public function handleResultSet(Node $input, Result $result, Recommendations $recommendations)
    {
        $recordsMap = [];
        foreach ($result->records() as $i => $record) {
            if (!$record->hasValue($this->idResultName())) {
                throw new \InvalidArgumentException(sprintf(
                    'The record does not contain a value with key "%s" in "%s"',
                    $this->idResultName(),
                    $this->name()
                ));
            }
            $recordsMap[$record->get($this->idResultName())] = $record;
        }

        foreach ($recommendations->getItems() as $recommendation) {
            if (array_key_exists($recommendation->item()->identity(), $recordsMap)) {
                $this->postProcess($input, $recommendation, $recordsMap[$recommendation->item()->identity()]);
            }
        }
    }

    public function idResultName()
    {
        return 'id';
    }
}
