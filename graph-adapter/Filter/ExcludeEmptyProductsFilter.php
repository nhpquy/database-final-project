<?php


namespace FinalProject\RecommendationEngine\Adapter\Filter;


use FinalProject\RecommendationEngine\Filter\Filter;
use GraphAware\Common\Type\Node;

class ExcludeEmptyProductsFilter implements Filter
{

    public function doInclude(Node $input, Node $item)
    {
        $count = $item->value("stock");
        if ($count < 1) {
            return false;
        }
        return true;
    }
}