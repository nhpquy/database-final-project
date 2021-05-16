<?php


namespace FinalProject\RecommendationEngine\Result;

class PartialScore
{
    /**
     * @var float
     */
    protected $value;

    /**
     * @var \FinalProject\RecommendationEngine\Result\Reason[]
     */
    protected $reasons = [];

    /**
     * @param float $value
     * @param mixed $reason
     */
    public function __construct($value = 0, $reason = null)
    {
        $this->value = (float)$value;
        $this->addReason($value, $reason);
    }

    /**
     * @param float $value
     * @param array $details
     */
    public function add($value, $reaon = null)
    {
        $this->value += (float)$value;
        $this->addReason($value, $reaon);
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param float $value
     * @param array $details
     */
    public function setNewValue($value, array $details = array())
    {
        $this->add(-($this->value - $value), $details);
    }

    /**
     * @return \FinalProject\RecommendationEngine\Result\Reason[]
     */
    public function getReasons()
    {
        return $this->reasons;
    }

    /**
     * @param $value
     * @param array $details
     */
    private function addReason($value, $detail = null)
    {
        if (!$detail) {
            return;
        }

        $this->reasons[] = new Reason($value, $detail);
    }
}
