<?php


namespace FinalProject\RecommendationEngine\Common;

class ObjectSet implements Set
{
    /**
     * @var string
     */
    protected $className;

    /**
     * @var array
     */
    protected $elements = [];

    final public function __construct($className)
    {
        if (!class_exists($className)) {
            throw new \InvalidArgumentException(sprintf('The classname %s does not exist', $className));
        }

        $this->className = $className;
    }

    public function add($element)
    {
        if ($this->valid($element) && !in_array($element, $this->elements)) {
            $this->elements[] = $element;
        }
    }

    /**
     * @return object[]
     */
    public function getAll()
    {
        return $this->elements;
    }

    public function size()
    {
        return count($this->elements);
    }

    public function get($key)
    {
        return $this->elements[$key];
    }

    /**
     * @param object $element
     *
     * @return bool
     */
    protected function valid($element)
    {
        return $element instanceof $this->className;
    }
}
