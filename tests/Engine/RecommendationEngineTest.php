<?php

namespace FinalProject\RecommendationEngine\Tests\Engine;

use FinalProject\RecommendationEngine\Engine\BaseRecommendationEngine;

class RecommendationEngineTest extends \PHPUnit_Framework_TestCase
{
    public function testWiring()
    {
        $stub = $this->getMockForAbstractClass(BaseRecommendationEngine::class);
    }
}