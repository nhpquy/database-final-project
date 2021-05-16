<?php


namespace FinalProject\RecommendationEngine\Result;

use FinalProject\RecommendationEngine\Context\Context;
use GraphAware\Common\Type\Node;

class Recommendations
{
    /**
     * @var \FinalProject\RecommendationEngine\Context\Context
     */
    protected $context;

    /**
     * @var \FinalProject\RecommendationEngine\Result\Recommendation[]
     */
    protected $recommendations = [];

    /**
     * @param \FinalProject\RecommendationEngine\Context\Context $context
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    /**
     * @param \GraphAware\Common\Type\Node $item
     *
     * @return \FinalProject\RecommendationEngine\Result\Recommendation
     */
    public function getOrCreate(Node $item)
    {
        if (array_key_exists($item->identity(), $this->recommendations)) {
            return $this->recommendations[$item->identity()];
        }

        $recommendation = new Recommendation($item);
        $this->recommendations[$item->identity()] = $recommendation;

        return $recommendation;
    }

    /**
     * @param \GraphAware\Common\Type\Node $item
     * @param string $name
     * @param \FinalProject\RecommendationEngine\Result\SingleScore $singleScore
     */
    public function add(Node $item, $name, SingleScore $singleScore)
    {
        $this->getOrCreate($item)->addScore($name, $singleScore);
    }

    /**
     * @param \FinalProject\RecommendationEngine\Result\Recommendations $recommendations
     */
    public function merge(Recommendations $recommendations)
    {
        foreach ($recommendations->getItems() as $recommendation) {
            $this->getOrCreate($recommendation->item())->addScores($recommendation->getScores());
        }
    }

    public function remove(Recommendation $recommendation)
    {
        if (!array_key_exists($recommendation->item()->identity(), $this->recommendations)) {
            return;
        }
        unset($this->recommendations[$recommendation->item()->identity()]);
    }

    /**
     * @return \FinalProject\RecommendationEngine\Result\Recommendation[]
     */
    public function getItems($size = null): array
    {
        if (is_int($size) && $size > 0) {
            return array_slice($this->recommendations, 0, $size);
        }

        return array_values($this->recommendations);
    }

    /**
     * @param $position
     *
     * @return \FinalProject\RecommendationEngine\Result\Recommendation
     */
    public function get($position): Recommendation
    {
        return array_values($this->recommendations)[$position];
    }

    /**
     * @return int
     */
    public function size(): int
    {
        return count($this->recommendations);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return \FinalProject\RecommendationEngine\Result\Recommendation|null
     */
    public function getItemBy($key, $value)
    {
        foreach ($this->getItems() as $recommendation) {
            if ($recommendation->item()->hasValue($key) && $recommendation->item()->value($key) === $value) {
                return $recommendation;
            }
        }

        return null;
    }

    /**
     * @param int $id
     * @return \FinalProject\RecommendationEngine\Result\Recommendation|null
     */
    public function getItemById($id)
    {
        foreach ($this->getItems() as $item) {
            if ($item->item()->identity() === $id) {
                return $item;
            }
        }

        return null;
    }

    public function sort()
    {
        usort($this->recommendations, function (Recommendation $recommendationA, Recommendation $recommendationB) {
            return $recommendationA->totalScore() <= $recommendationB->totalScore();
        });
    }

    /**
     * @return \FinalProject\RecommendationEngine\Context\Context
     */
    public function getContext(): Context
    {
        return $this->context;
    }
}
