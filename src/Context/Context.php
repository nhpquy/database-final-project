<?php


namespace FinalProject\RecommendationEngine\Context;

use FinalProject\RecommendationEngine\Config\Config;

interface Context
{
    /**
     * @return \FinalProject\RecommendationEngine\Config\Config
     */
    public function config(): Config;

    /**
     * @return bool
     */
    public function timeLeft(): bool;

    /**
     * @return \FinalProject\RecommendationEngine\Context\Statistics
     */
    public function getStatistics(): Statistics;
}
