<?php

namespace Strego\GoogleBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @link https://developers.google.com/analytics/devguides/collection/analyticsjs/events
 */
class Event
{

    /**
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     */
    public $action;

    /**
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     */
    public $category;

    /**
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     */
    public $label;

    /**
     * @Assert\Type(type="integer", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\Range(
     *      min = 0
     * )
     */
    public $value;
    
    /**
     * Used for automatic JSON transformation to indicate the event send
     * 
     */
    protected $hitType = 'event';

    public function __construct($category, $action, $label = null, $value = null)
    {
    	$this->action   = $action;
    	$this->category = $category;
    	$this->label    = $label;
    	$this->value    = $value;
    }

    /**
     * @return string $action
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return string $category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return string $label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return string $value
     */
    public function getValue()
    {
        return $this->value;
    }
}
