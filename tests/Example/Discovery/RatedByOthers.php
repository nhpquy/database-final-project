<?php

namespace FinalProject\RecommendationEngine\Tests\Example\Discovery;

use GraphAware\Common\Cypher\Statement;
use GraphAware\Common\Type\Node;
use FinalProject\RecommendationEngine\Context\Context;
use FinalProject\RecommendationEngine\Engine\SingleDiscoveryEngine;

class RatedByOthers extends SingleDiscoveryEngine
{
    public function discoveryQuery(Node $input, Context $context)
    {
        $query = 'MATCH (input:User) WHERE id(input) = {id}
        MATCH (input)-[:RATED]->(m)<-[:RATED]-(o)
        WITH distinct o
        MATCH (o)-[:RATED]->(reco)
        RETURN distinct reco LIMIT 500';

        return Statement::create($query, ['id' => $input->identity()]);
    }


    public function name()
    {
        return "rated_by_others";
    }

}