<?php


namespace FinalProject\RecommendationEngine\Adapter;


use FinalProject\RecommendationEngine\Adapter\Discovery\SameCategoryDiscovery;
use FinalProject\RecommendationEngine\Adapter\Discovery\SameTypeDiscovery;
use FinalProject\RecommendationEngine\Adapter\Filter\ExcludeEmptyProductsFilter;
use FinalProject\RecommendationEngine\Adapter\Post\RewardMostBuyPostProcessor;
use FinalProject\RecommendationEngine\Adapter\Post\RewardMostSalePostProcessor;
use FinalProject\RecommendationEngine\Adapter\Post\RewardMostViewPostProcessor;
use FinalProject\RecommendationEngine\Engine\BaseRecommendationEngine;

class PropertiesBasedProductRecommendationEngine extends BaseRecommendationEngine
{
    public function name(): string
    {
        return "properties_based_product_recommendation";
    }

    public function discoveryEngines(): array
    {
        return array(
            new SameTypeDiscovery(),
            new SameCategoryDiscovery()
        );
    }

    public function blacklistBuilders(): array
    {
        return array();
    }

    public function filters(): array
    {
        return array(new ExcludeEmptyProductsFilter());
    }

    public function postProcessors(): array
    {
        return array(
            new RewardMostViewPostProcessor(),
            new RewardMostBuyPostProcessor(),
            new RewardMostSalePostProcessor()
        );
    }
}