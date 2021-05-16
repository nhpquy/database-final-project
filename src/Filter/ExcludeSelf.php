<?php


namespace FinalProject\RecommendationEngine\Filter;

use GraphAware\Common\Type\Node;

class ExcludeSelf implements Filter
{
    public function doInclude(Node $input, Node $item)
    {
        return $input->identity() !== $item->identity();
    }
}
