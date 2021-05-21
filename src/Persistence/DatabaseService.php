<?php


namespace FinalProject\RecommendationEngine\Persistence;

use GraphAware\Neo4j\Client\ClientBuilder;
use GraphAware\Neo4j\Client\ClientInterface;

class DatabaseService
{
    private $driver;

    public function __construct($uri = null)
    {
        if ($uri !== null) {
            $this->driver = ClientBuilder::create()
                ->addConnection('default', $uri)
                ->build();
        }
    }

    /**
     * @return ClientInterface
     */
    public function getDriver(): ClientInterface
    {
        return $this->driver;
    }

    /**
     * @param \GraphAware\Neo4j\Client\ClientInterface $driver
     */
    public function setDriver(ClientInterface $driver)
    {
        $this->driver = $driver;
    }
}
