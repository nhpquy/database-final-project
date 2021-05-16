<?php


namespace FinalProject\RecommendationEngine\Result;

class Reason
{
    protected $value;

    protected $detail;

    public function __construct($value, $detail)
    {
        $this->value = (float)$value;
        $this->detail = $detail;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getDetail()
    {
        return $this->detail;
    }
}
