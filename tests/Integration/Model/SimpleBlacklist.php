<?php

namespace FinalProject\RecommendationEngine\Tests\Integration\Model;

use GraphAware\Common\Cypher\Statement;
use GraphAware\Common\Type\Node;
use FinalProject\RecommendationEngine\Filter\BaseBlacklistBuilder;

class SimpleBlacklist extends BaseBlacklistBuilder
{
    public function blacklistQuery(Node $input)
    {
        $query = 'MATCH (n) WHERE n.name = "Zoe" RETURN n as item';

        return Statement::prepare($query, ['id' => $input->identity()]);
    }

    public function name()
    {
        return 'simple_blacklist';
    }

}