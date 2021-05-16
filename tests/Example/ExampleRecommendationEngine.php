<?php

namespace FinalProject\RecommendationEngine\Tests\Example;

use FinalProject\RecommendationEngine\Engine\BaseRecommendationEngine;
use FinalProject\RecommendationEngine\Tests\Example\Discovery\FromSameGenreILike;
use FinalProject\RecommendationEngine\Tests\Example\Filter\AlreadyRatedBlackList;
use FinalProject\RecommendationEngine\Tests\Example\Filter\ExcludeOldMovies;
use FinalProject\RecommendationEngine\Tests\Example\PostProcessing\RewardWellRated;
use FinalProject\RecommendationEngine\Tests\Example\Discovery\RatedByOthers;

class ExampleRecommendationEngine extends BaseRecommendationEngine
{
    public function name()
    {
        return "example";
    }

    public function discoveryEngines()
    {
        return array(
            new RatedByOthers(),
            new FromSameGenreILike()
        );
    }

    public function blacklistBuilders()
    {
        return array(
            new AlreadyRatedBlackList()
        );
    }

    public function postProcessors()
    {
        return array(
            new RewardWellRated()
        );
    }

    public function filters()
    {
        return array(
            new ExcludeOldMovies()
        );
    }
}