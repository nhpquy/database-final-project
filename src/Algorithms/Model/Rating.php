<?php


namespace FinalProject\RecommendationEngine\Algorithms\Model;

class Rating
{
    /**
     * @var float
     */
    protected $rating;

    /**
     * @var int
     */
    protected $nodeId;

    public function __construct($rating, $nodeId)
    {
        $this->rating = (float)$rating;
        $this->nodeId = (int)$nodeId;
    }

    /**
     * @return float
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->nodeId;
    }
}
