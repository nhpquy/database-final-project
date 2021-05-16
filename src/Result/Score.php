<?php


namespace FinalProject\RecommendationEngine\Result;

class Score
{
    /**
     * @var float
     */
    protected $score = 0.0;

    /**
     * @var \FinalProject\RecommendationEngine\Result\SingleScore[]
     */
    protected $scores = [];

    /**
     * @param \FinalProject\RecommendationEngine\Result\SingleScore $score
     */
    public function add(SingleScore $score)
    {
        $this->scores[] = $score;
        $this->score += (float)$score->getScore();
    }

    /**
     * @return float
     */
    public function score()
    {
        return $this->score;
    }

    /**
     * @return \FinalProject\RecommendationEngine\Result\SingleScore[]
     */
    public function getScores()
    {
        return $this->scores;
    }
}
