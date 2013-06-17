<?php

namespace Strego\GoogleBundle;

use Strego\GoogleBundle\Model\MetricDimension;
use Strego\GoogleBundle\Model\Event;
use Strego\GoogleBundle\Model\Item;
use Strego\GoogleBundle\Model\Transaction;
use Strego\GoogleBundle\Model\PageView;
use Strego\GoogleBundle\Model\Tracker;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Analytics
{

    /**
     * @var TrackerFactory
     */
    protected $trackerFactory;


    public function __construct($trackerFactory) {
        $this->trackerFactory = $trackerFactory;
    }

    public function setConfig($key, $value, $trackerName = null)
    {
        $this->trackerFactory->getTracker($trackerName)->set($key, $value);
    }


    /**
     * @param string $name
     * @return Tracker
     * @throws InvalidArgumentException
     */
    public function getTracker($name = null)
    {
        return $this->trackerFactory->getTracker($name);
    }

    /**
     * @return array $trackers
     */
    public function getTrackers()
    {
        return $this->trackerFactory->getTrackers();
    }

    public function addPageView($page, $title = null, $tracker = null){
        $pageView = new PageView($page, $title);
        $this->getTracker($tracker)->addPageView($pageView);
    }
    
    public function addEvent($category, $action, $label = null, $value = null){
        $event = new Event($category, $action, $label, $value);
        $this->getTracker($tracker)->addEvent($event);
    }
    
    public function setTransaction($transaction, $tracker=null){
        $this->getTracker($tracker)->setTransaction($transaction);
    }
    
    public function addItem($item, $tracker=null){
        $this->getTracker($tracker)->addItem($item);
    }
    
    public function addMetricDim($index, $name, $value, $tracker = null){
        $metDim = new MetricDimension($index,$name,$value);
        $this->getTracker($tracker)->addMetricDim($metDim);
    }


    public function setDefaultTrackerName($defaultTrackerName)
    {
        $this->defaultTrackerName = $defaultTrackerName;
    }




}