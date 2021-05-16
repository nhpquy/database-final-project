<?php

namespace FinalProject\RecommendationEngine\Tests\Example\Discovery;

use GraphAware\Common\Cypher\Statement;
use GraphAware\Common\Type\Node;
use FinalProject\RecommendationEngine\Context\Context;
use FinalProject\RecommendationEngine\Engine\SingleDiscoveryEngine;

class FromSameGenreILike extends SingleDiscoveryEngine
{
    public function name()
    {
        return 'from_genre_i_like';
    }

    public function discoveryQuery(Node $input, Context $context)
    {
        $query = 'MATCH (input) WHERE id(input) = {id}
        MATCH (input)-[r:RATED]->(movie)-[:HAS_GENRE]->(genre)
        WITH distinct genre, sum(r.rating) as score
        ORDER BY score DESC
        LIMIT 15
        MATCH (genre)<-[:HAS_GENRE]-(reco)
        RETURN reco
        LIMIT 200';

        return Statement::create($query, ['id' => $input->identity()]);
    }

}