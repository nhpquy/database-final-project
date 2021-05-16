<?php


namespace FinalProject\RecommendationEngine\Algorithms\Similarity;

interface Similarity
{
    public function getSimilarity(array $xVector, array $yVector);
}
