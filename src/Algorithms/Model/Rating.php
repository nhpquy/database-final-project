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
    protected $userNodeId;

    public function __construct($rating, $userNodeId)
    {
        $this->rating = (float)$rating;
        $this->userNodeId = (int)$userNodeId;
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
        return $this->userNodeId;
    }
}
