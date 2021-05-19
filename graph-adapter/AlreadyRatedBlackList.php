<?php


namespace FinalProject\RecommendationEngine\Adapter\Discovery;


use FinalProject\RecommendationEngine\Filter\BaseBlacklistBuilder;
use GraphAware\Common\Cypher\Statement;
use GraphAware\Common\Cypher\StatementInterface;
use GraphAware\Common\Type\Node;

class AlreadyRatedBlackList extends BaseBlacklistBuilder
{

    public function blacklistQuery(Node $input): StatementInterface
    {
        $query = 'MATCH (input) WHERE id(input) = {inputId}
        MATCH (input)-[:RATED]->(product)
        RETURN product as item';

        return Statement::create($query, ['inputId' => $input->identity()]);
    }

    public function name(): string
    {
        return "already_rated";
    }
}