<?php


namespace FinalProject\RecommendationEngine\Filter;

use GraphAware\Common\Result\Result;
use GraphAware\Common\Type\Node;

interface BlackListBuilder
{
    /**
     * @param \GraphAware\Common\Type\Node $input
     *
     * @return \GraphAware\Common\Cypher\Statement
     */
    public function blacklistQuery(Node $input);

    /**
     * @param \GraphAware\Common\Result\Result
     *
     * @return \GraphAware\Common\Type\Node[]
     */
    public function buildBlackList(Result $result);

    /**
     * @return string
     */
    public function itemResultName();

    /**
     * @return string
     */
    public function name();
}
