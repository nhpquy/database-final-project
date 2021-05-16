<?php


namespace FinalProject\RecommendationEngine\Filter;

use GraphAware\Common\Result\Result;
use GraphAware\Common\Type\Node;

abstract class BaseBlacklistBuilder implements BlackListBuilder
{
    /**
     * @param \GraphAware\Common\Result\Result $result
     *
     * @return \GraphAware\Common\Type\Node[]
     */
    public function buildBlackList(Result $result)
    {
        $nodes = [];
        foreach ($result->records() as $record) {
            if ($record->hasValue($this->itemResultName()) && $record->value($this->itemResultName()) instanceof Node) {
                $nodes[] = $record->get($this->itemResultName());
            }
        }

        return $nodes;
    }

    public function itemResultName()
    {
        return 'item';
    }
}
