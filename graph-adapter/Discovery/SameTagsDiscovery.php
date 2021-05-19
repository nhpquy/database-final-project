<?php

namespace FinalProject\RecommendationEngine\Adapter\Discovery;

use FinalProject\RecommendationEngine\Context\Context;
use FinalProject\RecommendationEngine\Engine\SingleDiscoveryEngine;
use GraphAware\Common\Cypher\Statement;
use GraphAware\Common\Cypher\StatementInterface;
use GraphAware\Common\Type\Node;

class SameTagsDiscovery extends SingleDiscoveryEngine
{

    public function name(): string
    {
        return "same_tags";
    }

    public function discoveryQuery(Node $input, Context $context): StatementInterface
    {
        $query = 'MATCH (input:User) WHERE id(input) = $id
        MATCH (input)-[r:RATED]->(p)-[:HAS_TAG]->(tag)
        WITH distinct tag, sum(r.rating) as score
        ORDER BY score DESC
        LIMIT 15
        MATCH (tag)<-[:HAS_TAG]-(reco)
        RETURN distinct reco 
        LIMIT 200';

        return Statement::create($query, ['id' => $input->identity()]);
    }
}