<?php


namespace FinalProject\RecommendationEngine;

use FinalProject\RecommendationEngine\Engine\RecommendationEngine;
use FinalProject\RecommendationEngine\Persistence\DatabaseService;
use GraphAware\Common\Type\Node;
use GraphAware\Neo4j\Client\ClientInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class RecommenderService
{
    /**
     * @var \FinalProject\RecommendationEngine\Engine\RecommendationEngine[]
     */
    private $engines = [];

    /**
     * @var \FinalProject\RecommendationEngine\Persistence\DatabaseService
     */
    private $databaseService;

    /**
     * @var null|\Symfony\Component\EventDispatcher\EventDispatcher|\Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var null|\Psr\Log\LoggerInterface|\Psr\Log\NullLogger
     */
    private $logger;

    /**
     * RecommenderService constructor.
     *
     * @param \FinalProject\RecommendationEngine\Persistence\DatabaseService $databaseService
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface|null $eventDispatcher
     * @param \Psr\Log\LoggerInterface|null $logger
     */
    public function __construct(DatabaseService $databaseService, EventDispatcherInterface $eventDispatcher = null, LoggerInterface $logger = null)
    {
        $this->databaseService = $databaseService;
        $this->eventDispatcher = null !== $eventDispatcher ? $eventDispatcher : new EventDispatcher();
        $this->logger = null !== $logger ? $logger : new NullLogger();
    }

    /**
     * @param string $uri
     *
     * @return \FinalProject\RecommendationEngine\RecommenderService
     */
    public static function create($uri)
    {
        return new self(new DatabaseService($uri));
    }

    /**
     * @param ClientInterface $client
     *
     * @return \FinalProject\RecommendationEngine\RecommenderService
     */
    public static function createWithClient(ClientInterface $client)
    {
        $databaseService = new DatabaseService();
        $databaseService->setDriver($client);

        return new self($databaseService);
    }

    /**
     * @param $id
     *
     * @return \GraphAware\Bolt\Result\Type\Node|\GraphAware\Bolt\Result\Type\Path|\GraphAware\Bolt\Result\Type\Relationship|mixed
     */
    public function findInputById($id)
    {
        $id = (int)$id;
        $result = $this->databaseService->getDriver()->run('MATCH (n) WHERE id(n) = {id} RETURN n as input', ['id' => $id]);

        return $this->validateInput($result);
    }

    /**
     * @param string $label
     * @param string $key
     * @param mixed $value
     *
     * @return \GraphAware\Common\Type\Node
     */
    public function findInputBy($label, $key, $value)
    {
        $query = sprintf('MATCH (n:%s {%s: {value} }) RETURN n as input', $label, $key);
        $result = $this->databaseService->getDriver()->run($query, ['value' => $value]);

        return $this->validateInput($result);
    }

    /**
     * @param \GraphAware\Common\Result\Result $result
     *
     * @return \GraphAware\Common\Type\Node
     */
    public function validateInput($result)
    {
        if (count($result->records()) < 1 || !$result->getRecord()->value('input') instanceof Node) {
            throw new \InvalidArgumentException(sprintf('Node not found'));
        }

        return $result->getRecord()->value('input');
    }

    /**
     * @param $name
     *
     * @return \FinalProject\RecommendationEngine\Engine\RecommendationEngine
     */
    public function getRecommender($name)
    {
        if (!array_key_exists($name, $this->engines)) {
            throw new \InvalidArgumentException(sprintf('The Recommendation engine "%s" is not registered in the Recommender Service', $name));
        }

        return $this->engines[$name];
    }

    /**
     * @param \FinalProject\RecommendationEngine\Engine\RecommendationEngine $recommendationEngine
     */
    public function registerRecommendationEngine(RecommendationEngine $recommendationEngine)
    {
        $recommendationEngine->setDatabaseService($this->databaseService);
        $this->engines[$recommendationEngine->name()] = $recommendationEngine;
    }
}
