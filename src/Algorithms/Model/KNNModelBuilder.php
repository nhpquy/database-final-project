<?php


namespace FinalProject\RecommendationEngine\Algorithms\Model;

use FinalProject\RecommendationEngine\Algorithms\Similarity\Similarity;
use FinalProject\RecommendationEngine\Common\ObjectSet;

class KNNModelBuilder
{
    protected $model;

    protected $similarityFunction;

    protected $dataset;

    public function __construct($model = null, Similarity $similarityFunction = null, $dataset = null)
    {
        $this->model = $model;
        $this->similarityFunction = $similarityFunction;
        $this->dataset = $dataset;
    }

    public function computeSimilarity(ObjectSet $tfSource, ObjectSet $tfDestination)
    {
        $vectors = $this->createVectors($tfSource, $tfDestination);

        return $this->similarityFunction->getSimilarity($vectors[0], $vectors[1]);
    }

    public function createVectors(ObjectSet $tfSource, ObjectSet $tfDestination)
    {
        $ratings = [];
        foreach ($tfSource->getAll() as $source) {
            /* @var \FinalProject\RecommendationEngine\Algorithms\Model\Rating $source */
            $ratings[$source->getId()][0] = $source->getRating();
        }

        foreach ($tfDestination->getAll() as $dest) {
            /* @var \FinalProject\RecommendationEngine\Algorithms\Model\Rating $dest */
            $ratings[$dest->getId()][1] = $dest->getRating();
        }
        ksort($ratings);

        $xVector = [];
        $yVector = [];

        foreach ($ratings as $k => $rating) {
            $xVector[] = array_key_exists(0, $ratings[$k]) ? $ratings[$k][0] : 0;
            $yVector[] = array_key_exists(1, $ratings[$k]) ? $ratings[$k][1] : 0;
        }

        return array($xVector, $yVector);
    }
}
