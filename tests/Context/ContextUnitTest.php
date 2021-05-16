<?php

namespace FinalProject\RecommendationEngine\Tests\Context;

use FinalProject\RecommendationEngine\Context\SimpleContext;
use FinalProject\RecommendationEngine\Tests\Helper\FakeNode;
use FinalProject\RecommendationEngine\Config\Config;

class ContextUnitTest extends \PHPUnit_Framework_TestCase
{
    public function testDefault()
    {
        $input = FakeNode::createDummy();
        $context = new SimpleContext();
        $this->assertInstanceOf(Config::class, $context->config());
    }
}

