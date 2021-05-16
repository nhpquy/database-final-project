<?php


namespace FinalProject\RecommendationEngine\Filter;

use GraphAware\Common\Type\Node;

interface Filter
{
    /**
     * Returns whether or not the recommended node should be included in the recommendation.
     *
     * @param \GraphAware\Common\Type\Node $input
     * @param \GraphAware\Common\Type\Node $item
     *
     * @return bool
     */
    public function doInclude(Node $input, Node $item);
}
