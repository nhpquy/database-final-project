<?php

namespace FinalProject\RecommendationEngine\Tests\Example\Filter;

use GraphAware\Common\Cypher\Statement;
use GraphAware\Common\Type\Node;
use FinalProject\RecommendationEngine\Filter\BaseBlacklistBuilder;

class AlreadyRatedBlackList extends BaseBlacklistBuilder
{
    public function blacklistQuery(Node $input)
    {
        $query = 'MATCH (input) WHERE id(input) = {inputId}
        MATCH (input)-[:RATED]->(movie)
        RETURN movie as item';

        return Statement::create($query, ['inputId' => $input->identity()]);
    }

    public function name()
    {
        return 'already_rated';
    }
}