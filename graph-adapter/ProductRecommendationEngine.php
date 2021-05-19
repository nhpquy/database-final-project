<?php


namespace FinalProject\RecommendationEngine\Adapter\Discovery;


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
        return array(new ExcludeEmptyProducts());
    }

    public function postProcessors(): array
    {
        return array(new RewardWellRatedPostProcessor());
    }
}