<?php


namespace FinalProject\RecommendationEngine\Post;

use FinalProject\RecommendationEngine\Graph\Direction;
use FinalProject\RecommendationEngine\Result\Recommendation;
use FinalProject\RecommendationEngine\Result\SingleScore;
use GraphAware\Common\Cypher\Statement;
use GraphAware\Common\Result\RecordCursorInterface;
use GraphAware\Common\Type\Node;

abstract class RewardSomethingShared implements CypherAwarePostProcessor
{
    abstract public function relationshipType();

    public function relationshipDirection()
    {
        return Direction::BOTH;
    }

    final public function buildQuery(Node $input, Recommendation $recommendation)
    {
        $relationshipPatterns = [
            Direction::BOTH => array('-[:%s]-', '-[:%s]-'),
            Direction::INCOMING => array('<-[:%s]-', '-[:%s]->'),
            Direction::OUTGOING => array('-[:%s]->', '<-[:%s]-'),
        ];

        $relPattern = sprintf($relationshipPatterns[$this->relationshipDirection()][0], $this->relationshipType());
        $inversedRelPattern = sprintf($relationshipPatterns[$this->relationshipDirection()][1], $this->relationshipType());

        $query = 'MATCH (input) WHERE id(input) = {inputId}, (item) WHERE id(item) = {itemId}
        MATCH (input)' . $relPattern . '(shared)' . $inversedRelPattern . '(item)
        RETURN shared as sharedThing';

        return Statement::create($query, ['inputId' => $input->identity(), 'itemId' => $recommendation->item()->identity()]);
    }

    public function postProcess(Node $input, Recommendation $recommendation, RecordCursorInterface $result = null)
    {
        if (null === $result) {
            throw new \RuntimeException(sprintf('Expected a non-null result in %s::postProcess()', get_class($this)));
        }

        if (count($result->records()) > 0) {
            foreach ($result->records() as $record) {
                $recommendation->addScore($this->name(), new SingleScore(1));
            }
        }
    }
}
