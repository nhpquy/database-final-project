<?php



namespace FinalProject\RecommendationEngine\Tests\Engine;

use GraphAware\Common\Cypher\Statement;
use FinalProject\RecommendationEngine\Config\SimpleConfig;
use FinalProject\RecommendationEngine\Context\SimpleContext;
use FinalProject\RecommendationEngine\Engine\SingleDiscoveryEngine;
use FinalProject\RecommendationEngine\Tests\Helper\FakeNode;

/**
 * @group engine
 */
class SingleDiscoveryEngineTest extends \PHPUnit_Framework_TestCase
{
    public function testInit()
    {
        $engine = new TestDiscoveryEngine();
        $this->assertInstanceOf(SingleDiscoveryEngine::class, $engine);
        $input = FakeNode::createDummy();
        $this->assertInstanceOf(Statement::class, $engine->discoveryQuery($input, new SimpleContext()));
        $this->assertEquals("MATCH (n) WHERE id(n) <> {inputId} RETURN n", $engine->discoveryQuery($input, new SimpleContext())->text());
        $this->assertEquals("score", $engine->scoreResultName());
        $this->assertEquals("reco", $engine->recoResultName());
        $this->assertEquals(1, $engine->defaultScore());
        $this->assertEquals("test_discovery", $engine->name());
    }

    public function testParametersBuilding()
    {
        $engine = new TestDiscoveryEngine();
        $input = FakeNode::createDummy();
        $this->assertEquals($input->identity(), $engine->discoveryQuery($input, new SimpleContext())->parameters()['inputId']);
        $this->assertCount(1, $engine->discoveryQuery($input, new SimpleContext())->parameters());
    }

    public function testOverride()
    {
        $engine = new OverrideDiscoveryEngine();
        $input = FakeNode::createDummy();
        $context = new SimpleContext(new SimpleConfig());
        $this->assertCount(2, $engine->discoveryQuery($input, $context)->parameters());
        $this->assertEquals($input->identity(), $engine->discoveryQuery($input, $context)->parameters()['input']);
        $this->assertEquals("recommendation", $engine->recoResultName());
        $this->assertEquals("rate", $engine->scoreResultName());
        $this->assertEquals("source", $engine->idParamName());
        $this->assertEquals(10, $engine->defaultScore());
    }
}