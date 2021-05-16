<?php

namespace FinalProject\RecommendationEngine\Demo\Github;

use GraphAware\Common\Result\RecordViewInterface;
use GraphAware\Common\Type\NodeInterface;
use GraphAware\Common\Cypher\Statement;
use FinalProject\RecommendationEngine\Result\SingleScore;

class FollowedByFollowers extends \FinalProject\RecommendationEngine\Engine\SingleDiscoveryEngine
{
    public function name()
    {
        return 'followed_by_followers';
    }

    public function discoveryQuery(NodeInterface $input)
    {
        $query = 'MATCH (input) WHERE id(input) = {id}
        MATCH (input)<-[:FOLLOWS]-(follower)-[:FOLLOWS]->(reco)
        WHERE size((follower)-[:FOLLOWS]->()) < {max_follows}
        RETURN reco, count(*) as score
        LIMIT 100';

        return Statement::create($query, ['id' => $input->identity(), 'max_follows' => 200]);
    }

    public function buildScore(NodeInterface $input, NodeInterface $item, RecordViewInterface $record)
    {
        return new SingleScore($record->get('score'));
    }


}