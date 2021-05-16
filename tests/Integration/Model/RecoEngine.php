<?php

namespace FinalProject\RecommendationEngine\Tests\Integration\Model;

use FinalProject\RecommendationEngine\Engine\BaseRecommendationEngine;
use FinalProject\RecommendationEngine\Filter\ExcludeSelf;

class RecoEngine extends BaseRecommendationEngine
{
    public function name() : string
    {
        return 'find_friends';
    }

    public function discoveryEngines() : array
    {
        return array(
            new FriendsEngine()
        );
    }

    public function blacklistBuilders() : array
    {
        return array(
            new SimpleBlacklist()
        );
    }


}