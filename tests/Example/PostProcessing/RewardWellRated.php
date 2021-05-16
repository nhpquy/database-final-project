<?php

namespace FinalProject\RecommendationEngine\Tests\Example\PostProcessing;

use GraphAware\Common\Cypher\Statement;
use GraphAware\Common\Result\Record;
use GraphAware\Common\Type\Node;
use FinalProject\RecommendationEngine\Post\RecommendationSetPostProcessor;
use FinalProject\RecommendationEngine\Result\Recommendation;
use FinalProject\RecommendationEngine\Result\Recommendations;
use FinalProject\RecommendationEngine\Result\SingleScore;

class RewardWellRated extends RecommendationSetPostProcessor
{
    public function buildQuery(Node $input, Recommendations $recommendations)
    {
        $query = 'UNWIND {ids} as id
        MATCH (n) WHERE id(n) = id
        MATCH (n)<-[r:RATED]-(u)
        RETURN id(n) as id, sum(r.rating) as score';

        $ids = [];
        foreach ($recommendations->getItems() as $item) {
            $ids[] = $item->item()->identity();
        }

        return Statement::create($query, ['ids' => $ids]);
    }

    public function postProcess(Node $input, Recommendation $recommendation, Record $record)
    {
        $recommendation->addScore($this->name(), new SingleScore($record->get('score'), 'total_ratings_relationships'));
    }

    public function name()
    {
        return "reward_well_rated";
    }

}