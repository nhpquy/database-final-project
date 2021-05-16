<?php

namespace FinalProject\RecommendationEngine\Tests\Integration\Model;

use GraphAware\Common\Cypher\Statement;
use GraphAware\Common\Type\Node;
use FinalProject\RecommendationEngine\Context\Context;
use FinalProject\RecommendationEngine\Engine\SingleDiscoveryEngine;
use GraphAware\Common\Cypher\StatementInterface;

class FriendsEngine extends SingleDiscoveryEngine
{
    public function name() : string
    {
        return 'friends_discovery';
    }

    public function discoveryQuery(Node $input, Context $context) : StatementInterface
    {
        $query = 'MATCH (n) WHERE id(n) = {id}
        MATCH (n)-[:FRIEND]->(friend)-[:FRIEND]->(reco)
        WHERE NOT (n)-[:FRIEND]->(reco)
        RETURN reco, count(*) as score';

        return Statement::prepare($query, ['id' => $input->identity()]);
    }

}