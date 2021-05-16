<?php

namespace FinalProject\RecommendationEngine\Demo\Github;

class RecommendationEngine extends \FinalProject\RecommendationEngine\Engine\BaseRecommendationEngine
{
    public function discoveryEngines()
    {
        return array(
            new FollowedByFollowers(),
            new SameContribution()
        );
    }

    public function postProcessors()
    {
        return array(
            new PenalizeTooMuchFollowers()
        );
    }


    public function name()
    {
        return 'github_who_to_follow';
    }

}