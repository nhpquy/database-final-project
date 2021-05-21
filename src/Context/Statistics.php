<?php


namespace FinalProject\RecommendationEngine\Context;

use Symfony\Component\Stopwatch\Stopwatch;

class Statistics
{
    private static $DISCOVERY_KEY = 'discovery';

    private static $POST_PROCESS_KEY = 'post_process';

    /**
     * @var \Symfony\Component\Stopwatch\Stopwatch
     */
    protected $stopwatch;

    /**
     * @var float
     */
    protected $discoveryTime;

    /**
     * @var float
     */
    protected $postProcessingTime;

    public function __construct()
    {
        $this->stopwatch = new Stopwatch();
    }

    public function startDiscovery()
    {
        $this->stopwatch->start(self::$DISCOVERY_KEY);
    }

    public function stopDiscovery()
    {
        $e = $this->stopwatch->stop(self::$DISCOVERY_KEY);
        $this->discoveryTime = $e->getDuration();
    }

    public function startPostProcess()
    {
        $this->stopwatch->start(self::$POST_PROCESS_KEY);
    }

    public function stopPostProcess()
    {
        $e = $this->stopwatch->stop(self::$POST_PROCESS_KEY);
        $this->postProcessingTime = $e->getDuration();
    }

    /**
     * @return array
     */
    public function getTimes(): array
    {
        return array(
            self::$DISCOVERY_KEY => $this->discoveryTime,
            self::$POST_PROCESS_KEY => $this->postProcessingTime,
            'total' => $this->discoveryTime + $this->postProcessingTime
        );
    }

    /**
     * @return float
     */
    public function getCurrentTimeSpent(): float
    {
        $discovery = null !== $this->discoveryTime ? $this->discoveryTime : 0.0;
        $postProcess = null !== $this->postProcessingTime ? $this->postProcessingTime : 0.0;

        return $discovery + $postProcess;
    }
}