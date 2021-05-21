<?php


namespace FinalProject\RecommendationEngine\Adapter\Post;


use FinalProject\RecommendationEngine\Post\RecommendationSetPostProcessor;
use FinalProject\RecommendationEngine\Result\Recommendation;
use FinalProject\RecommendationEngine\Result\Recommendations;
use FinalProject\RecommendationEngine\Result\SingleScore;
use GraphAware\Common\Cypher\Statement;
use GraphAware\Common\Result\Record;
use GraphAware\Common\Type\Node;

class RewardMostViewPostProcessor extends RecommendationSetPostProcessor
{

    public function name(): string
    {
        return "reward_most_view";
    }

    public function buildQuery(Node $input, Recommendations $recommendations): Statement
    {
        $query = 'UNWIND $ids as id
        MATCH (product:Product) WHERE id(product) = id
        RETURN id(product) as id, product.view as score';

        $ids = [];
        foreach ($recommendations->getItems() as $item) {
            $ids[] = $item->item()->identity();
        }

        return Statement::create($query, ['ids' => $ids]);
    }

    public function postProcess(Node $input, Recommendation $recommendation, Record $record)
    {
        $recommendation->addScore($this->name(), new SingleScore($record->get('score'), 'most_view'));
    }
}