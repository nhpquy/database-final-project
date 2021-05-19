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
        $query = 'MATCH (input:User) WHERE id(input) = {id}
        MATCH (input)-[:RATED]->(p)
        WITH p
        MATCH (p)-[:HAS_TAG]->(t)<-[:HAS_TAG]-(reco)
        RETURN distinct reco LIMIT 500';

        return Statement::create($query, ['id' => $input->identity()]);
    }
}