<?php


namespace FinalProject\RecommendationEngine\Post;

use FinalProject\RecommendationEngine\Result\Recommendation;
use GraphAware\Common\Type\Node;

interface CypherAwarePostProcessor extends PostProcessor
{
    /**
     * @param \GraphAware\Common\Type\Node $input
     * @param \FinalProject\RecommendationEngine\Result\Recommendation $recommendation
     *
     * @return \GraphAware\Common\Cypher\Statement the statement to be executed
     */
    public function buildQuery(Node $input, Recommendation $recommendation);
}
