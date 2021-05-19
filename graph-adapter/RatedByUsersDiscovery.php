<?php

namespace FinalProject\RecommendationEngine\Adapter\Discovery;

use FinalProject\RecommendationEngine\Context\Context;
use FinalProject\RecommendationEngine\Engine\SingleDiscoveryEngine;
use GraphAware\Common\Cypher\Statement;
use GraphAware\Common\Cypher\StatementInterface;
use GraphAware\Common\Type\Node;

class RatedByUsersDiscovery extends SingleDiscoveryEngine
{

    public function name(): string
    {
        return "rated_by_user";
    }

    public function discoveryQuery(Node $input, Context $context): StatementInterface
    {
        $query = 'MATCH (input:User) WHERE id(input) = {id}
        MATCH (input)-[:RATED]->(p)<-[:RATED]-(o)
        WITH distinct o
        MATCH (o)-[:RATED]->(reco)
        RETURN distinct reco LIMIT 500';

        return Statement::create($query, ['id' => $input->identity()]);
    }
}