<?php


namespace FinalProject\RecommendationEngine\Adapter;


use FinalProject\RecommendationEngine\Adapter\BlackList\AlreadyRatedBlackList;
use FinalProject\RecommendationEngine\Adapter\Discovery\RatedByUsersDiscovery;
use FinalProject\RecommendationEngine\Adapter\Discovery\SameTagsDiscovery;
use FinalProject\RecommendationEngine\Adapter\Filter\ExcludeEmptyProductsFilter;
use FinalProject\RecommendationEngine\Adapter\Post\RewardWellRatedPostProcessor;
use FinalProject\RecommendationEngine\Engine\BaseRecommendationEngine;

class ProductRecommendationEngine extends BaseRecommendationEngine
{
    public function name(): string
    {
        return "product_recommendation";
    }

    public function discoveryEngines(): array
    {
        return array(new RatedByUsersDiscovery(), new SameTagsDiscovery());
    }

    public function blacklistBuilders(): array
    {
        return array(new AlreadyRatedBlackList());
    }

    public function filters(): array
    {
        return array(new ExcludeEmptyProductsFilter());
    }

    public function postProcessors(): array
    {
        return array(new RewardWellRatedPostProcessor());
    }
}