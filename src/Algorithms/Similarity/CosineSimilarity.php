<?php


namespace FinalProject\RecommendationEngine\Algorithms\Similarity;

class CosineSimilarity implements Similarity
{
    public function getSimilarity(array $xVector, array $yVector)
    {
        $a = $this->getDotProduct($xVector, $yVector);
        $b = $this->getNorm($xVector) * $this->getNorm($yVector);

        if ($b > 0) {
            return $a / $b;
        }

        return 0;
    }

    private function getDotProduct(array $xVector, array $yVector)
    {
        $sum = 0.0;
        foreach ($xVector as $k => $v) {
            $sum += (float)($xVector[$k] * $yVector[$k]);
        }

        return $sum;
    }

    private function getNorm(array $vector)
    {
        $sum = 0.0;
        foreach ($vector as $k => $v) {
            $sum += (float)($vector[$k] * $vector[$k]);
        }

        return sqrt($sum);
    }
}
