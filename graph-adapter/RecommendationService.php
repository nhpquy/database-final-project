<?php


namespace FinalProject\RecommendationEngine\Adapter\Discovery;


use FinalProject\RecommendationEngine\Context\SimpleContext;
use FinalProject\RecommendationEngine\RecommenderService;
use FinalProject\RecommendationEngine\Result\Recommendations;

class RecommendationService
{
    /**
     * @var \FinalProject\RecommendationEngine\RecommenderService
     */
    protected $service;

    public function __contruct($databaseUri)
    {
        $this->service = RecommenderService::create($databaseUri);
        $this->service->registerRecommendationEngine(new ProductRecommendationEngine());
    }

    public function recommendProductForUserWithId($id): Recommendations
    {
        $input = $this->service->findInputBy('User', 'id', $id);
        $recommendationEngine = $this->service->getRecommender("product_recommendation");

        return $recommendationEngine->recommend($input, new SimpleContext());
    }
}