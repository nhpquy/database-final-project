<?php

namespace FinalProject\RecommendationEngine\Executor;

use FinalProject\RecommendationEngine\Persistence\DatabaseService;

class BaseExecutor
{
    protected $databaseService;

    public function __construct(DatabaseService $databaseService)
    {
        $this->databaseService = $databaseService;
    }
}
