<?php

namespace FinalProject\RecommendationEngine\Adapter\Discovery;

use FinalProject\RecommendationEngine\Context\Context;
use FinalProject\RecommendationEngine\Engine\SingleDiscoveryEngine;
use GraphAware\Common\Cypher\Statement;
use GraphAware\Common\Cypher\StatementInterface;
use GraphAware\Common\Type\Node;

class SameCategoryDiscovery extends SingleDiscoveryEngine
{

    public function name(): string
    {
        return "same_category";
    }

    public function discoveryQuery(Node $input, Context $context): StatementInterface
    {
        $query = 'MATCH (input:Product) WHERE id(input) = $id
        MATCH (input)-[:HAS_CATEGORY]->(cate)
        WITH distinct cate
        MATCH (cate)<-[:HAS_CATEGORY]-(reco)
        RETURN distinct reco
        ORDER BY reco.view DESC
        LIMIT 200';

        return Statement::create($query, ['id' => $input->identity()]);
    }
}