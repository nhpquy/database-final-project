<?php



namespace FinalProject\RecommendationEngine\Tests\Engine;

use GraphAware\Common\Cypher\Statement;
use GraphAware\Common\Cypher\StatementInterface;
use GraphAware\Common\Result\Record;
use GraphAware\Common\Type\Node;
use FinalProject\RecommendationEngine\Context\Context;
use FinalProject\RecommendationEngine\Result\SingleScore;

class OverrideDiscoveryEngine extends TestDiscoveryEngine
{
    public function discoveryQuery(Node $input, Context $context) : StatementInterface
    {
        $query = "MATCH (n) WHERE id(n) <> {input}
        RETURN n LIMIT {limit}";

        return Statement::create($query, ['input' => $input->identity(), 'limit' => 300]);
    }

    public function buildScore(Node $input, Node $item, Record $record, Context $context) : SingleScore
    {
        return parent::buildScore($input, $item, $record, $context);
    }

    public function idParamName() : string
    {
        return "source";
    }

    public function recoResultName() : string
    {
       return "recommendation";
    }

    public function scoreResultName() : string
    {
        return "rate";
    }

    public function defaultScore() : float
    {
        return 10;
    }

}