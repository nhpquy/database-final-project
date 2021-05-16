<?php


namespace FinalProject\RecommendationEngine\Context;

use FinalProject\RecommendationEngine\Config\Config;
use FinalProject\RecommendationEngine\Config\SimpleConfig;
use GraphAware\Common\Type\Node;

class SimpleContext implements Context
{
    /**
     * @var \FinalProject\RecommendationEngine\Config\Config
     */
    protected $config;

    /**
     * @var \FinalProject\RecommendationEngine\Context\Statistics
     */
    protected $statistics;

    /**
     * @param \FinalProject\RecommendationEngine\Config\Config $config
     */
    public function __construct(Config $config = null)
    {
        $this->config = null !== $config ? $config : new SimpleConfig();
        $this->statistics = new Statistics();
    }

    /**
     * {@inheritdoc}
     */
    public function config(): Config
    {
        return $this->config;
    }

    /**
     * {@inheritdoc}
     */
    public function timeLeft(): bool
    {
        return $this->statistics->getCurrentTimeSpent() < $this->config()->limit();
    }

    public function getStatistics(): Statistics
    {
        return $this->statistics;
    }
}
