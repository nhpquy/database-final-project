<?php


namespace FinalProject\RecommendationEngine\Transactional;

interface CypherAware
{
    public function query();

    public function parameters();
}
