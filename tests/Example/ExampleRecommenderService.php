<?php

namespace FinalProject\RecommendationEngine\Tests\Example;

use FinalProject\RecommendationEngine\Context\SimpleContext;
use FinalProject\RecommendationEngine\RecommenderService;

class ExampleRecommenderService
{
    /**
     * @var \FinalProject\RecommendationEngine\RecommenderService
     */
    protected $service;

    /**
     * ExampleRecommenderService constructor.
     * @param string $databaseUri
     */
    public function __construct($databaseUri)
    {
        $this->service = RecommenderService::create($databaseUri);
        $this->service->registerRecommendationEngine(new ExampleRecommendationEngine());
    }

    /**
     * @param int $id
     * @return \FinalProject\RecommendationEngine\Result\Recommendations
     */
    public function recommendMovieForUserWithId($id)
    {
        $input = $this->service->findInputBy('User', 'id', $id);
        $recommendationEngine = $this->service->getRecommender("user_movie_reco");

        return $recommendationEngine->recommend($input, new SimpleContext());
    }
}