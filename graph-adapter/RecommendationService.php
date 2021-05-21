<?php


namespace FinalProject\RecommendationEngine\Adapter;


use FinalProject\RecommendationEngine\Context\SimpleContext;
use FinalProject\RecommendationEngine\RecommenderService;
use FinalProject\RecommendationEngine\Result\Recommendations;

class RecommendationService
{
    /**
     * @var \FinalProject\RecommendationEngine\RecommenderService
     */
    protected $service;

    public function __construct($databaseUri)
    {
        $this->service = RecommenderService::create($databaseUri);
        $this->service->registerRecommendationEngine(new RatingBasedProductRecommendationEngine());
        $this->service->registerRecommendationEngine(new PropertiesBasedProductRecommendationEngine());
    }

    public function recommendProductForUserWithUserId($id): Recommendations
    {
        $input = $this->service->findInputBy('User', 'id', $id);
        $recommendationEngine = $this->service->getRecommender("rating_based_product_recommendation");

        return $recommendationEngine->recommend($input, new SimpleContext());
    }

    public function recommendProductForUserWithProductId($id): Recommendations
    {
        $input = $this->service->findInputBy('Product', 'id', $id);
        $recommendationEngine = $this->service->getRecommender("properties_based_product_recommendation");

        return $recommendationEngine->recommend($input, new SimpleContext());
    }

    /**
     * @return \FinalProject\RecommendationEngine\RecommenderService
     */
    public function getService(): RecommenderService
    {
        return $this->service;
    }
}