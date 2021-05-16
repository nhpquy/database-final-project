<?php



namespace FinalProject\RecommendationEngine\Tests\Engine;

use GraphAware\Common\Cypher\Statement;
use GraphAware\Common\Cypher\StatementInterface;
use FinalProject\RecommendationEngine\Context\Context;
use FinalProject\RecommendationEngine\Engine\SingleDiscoveryEngine;
use GraphAware\Common\Type\Node;

class TestDiscoveryEngine extends SingleDiscoveryEngine
{
    public function discoveryQuery(Node $input, Context $context) : StatementInterface
    {
        $query = "MATCH (n) WHERE id(n) <> {inputId} RETURN n";

        return Statement::create($query, ['inputId' => $input->identity()]);
    }

    public function name() : string
    {
        return "test_discovery";
    }

}