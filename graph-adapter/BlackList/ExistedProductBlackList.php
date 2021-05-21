<?php


namespace FinalProject\RecommendationEngine\Adapter\BlackList;


use FinalProject\RecommendationEngine\Filter\BaseBlacklistBuilder;
use GraphAware\Common\Cypher\Statement;
use GraphAware\Common\Cypher\StatementInterface;
use GraphAware\Common\Type\Node;

class ExistedProductBlackList extends BaseBlacklistBuilder
{

    public function blacklistQuery(Node $input): StatementInterface
    {
        $query = 'MATCH (input:Product) WHERE id(input) = $inputId
        RETURN input as item';

        return Statement::create($query, ['inputId' => $input->identity()]);
    }

    public function name(): string
    {
        return "already_existed";
    }
}