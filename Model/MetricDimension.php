<?php

namespace Strego\GoogleBundle\Model;

class MetricDimension
{
    public $index;
    public $name;
    public $value;


    public function __construct($index, $name, $value)
    {
        $this->index = $index;
        $this->name = $name;
        $this->value = $value;
    }

    public function getIndex()
    {
        return $this->index;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

}
