<?php

namespace FinalProject\RecommendationEngine\Adapter\Discovery;

use FinalProject\RecommendationEngine\Context\Context;
use FinalProject\RecommendationEngine\Engine\SingleDiscoveryEngine;
use GraphAware\Common\Cypher\Statement;
use GraphAware\Common\Cypher\StatementInterface;
use GraphAware\Common\Type\Node;

class SameTypeDiscovery extends SingleDiscoveryEngine
{

    public function name(): string
    {
        return "same_type";
    }

    public function discoveryQuery(Node $input, Context $context): StatementInterface
    {
        $query = 'MATCH (input:Product) WHERE id(input) = $id
        MATCH (product)-[:HAS_TYPE]->(type)
        WITH distinct type
        MATCH (type)<-[:HAS_TYPE]-(reco)
        RETURN distinct reco 
        ORDER BY reco.view DESC
        LIMIT 200';

        return Statement::create($query, ['id' => $input->identity()]);
    }
}