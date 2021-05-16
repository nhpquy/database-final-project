<?php


namespace FinalProject\RecommendationEngine\Config;

interface Config
{
    const UNLIMITED = PHP_INT_MAX;

    /**
     * @return int maximum number of items to recommend
     */
    public function limit();

    /**
     * @return int maximum number of ms the recommendation-computing process should take. Note that it is
     *             for information only, it is the responsibility of the engines to honour this configuration or not.
     */
    public function maxTime();
}
