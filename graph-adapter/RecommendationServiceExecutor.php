<?php

require_once __DIR__ . '/../vendor/autoload.php';

use FinalProject\RecommendationEngine\Adapter\RecommendationService;

$userLogin = "neo4j";
$password = "flood-wholesales-puffs";
$recommender = new RecommendationService(sprintf("http://%s:%s@52.91.233.197:7474", $userLogin, $password));
$databaseService = $recommender->getService()->getDatabaseService();
$userId = 5;
$productId = 514;
$recommendations = $recommender->recommendProductForUserWithProductId($productId);

foreach ($recommendations->getItems(10) as $reco) {
    echo $reco->item()->get('id') . PHP_EOL;
    echo $reco->totalScore() . PHP_EOL;
    foreach ($reco->getScores() as $name => $score) {
        echo "\t" . $name . ':' . $score->score() . PHP_EOL;
    }
}
