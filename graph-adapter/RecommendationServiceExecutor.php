<?php

require_once __DIR__ . '/../vendor/autoload.php';

use FinalProject\RecommendationEngine\Adapter\RecommendationService;

$userLogin = "user";
$password = "123456";
$recommender = new RecommendationService(sprintf("http://%s:%s@localhost:7474", $userLogin, $password));
$databaseService = $recommender->getService()->getDatabaseService();
$userId = 5;
$productId = 500;
$recommendations = $recommender->recommendProductForUserWithProductId($productId);

foreach ($recommendations->getItems(10) as $reco) {
    echo $reco->item()->get('id') . PHP_EOL;
    echo $reco->totalScore() . PHP_EOL;
    foreach ($reco->getScores() as $name => $score) {
        echo "\t" . $name . ':' . $score->score() . PHP_EOL;
    }
}
