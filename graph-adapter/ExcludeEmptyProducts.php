<?php


namespace FinalProject\RecommendationEngine\Adapter\Discovery;


use FinalProject\RecommendationEngine\Filter\Filter;
use GraphAware\Common\Type\Node;

class ExcludeEmptyProducts implements Filter
{

    public function doInclude(Node $input, Node $item)
    {
        $count = $item->value("count");
        if ($count < 1) {
            return false;
        }
        return true;
    }
}