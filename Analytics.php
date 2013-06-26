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


    public function getDefaultTracker(){
        return $this->trackerFactory->getDefaultTracker();
    }




    /*************** Old stuff from original Bundle ******************/

    private $container;
    private $customVariables = array();
    private $pageViewsWithBaseUrl = true;
    private $whitelist;
    private $api_key;
    private $client_id;
    private $table_id;


    public function excludeBaseUrl()
    {
        $this->pageViewsWithBaseUrl = false;
    }

    public function includeBaseUrl()
    {
        $this->pageViewsWithBaseUrl = true;
    }

    private function isValidConfigKey($trackerKey)
    {
        if (!array_key_exists($trackerKey, $this->trackers)) {
            throw new \InvalidArgumentException(sprintf(
                'There is no tracker configuration assigned with the key "%s".',
                $trackerKey
            ));
        }

        return true;
    }

    private function setTrackerProperty($tracker, $property, $value)
    {
        if ($this->isValidConfigKey($tracker)) {
            $this->trackers[$tracker][$property] = $value;
        }
    }

    private function getTrackerProperty($tracker, $property)
    {
        if (!$this->isValidConfigKey($tracker)) {
            return;
        }

        if (array_key_exists($property, $this->trackers[$tracker])) {
            return $this->trackers[$tracker][$property];
        }
    }

    /**
     * @param string $trackerKey
     * @param boolean $allowAnchor
     */
    public function setAllowAnchor($trackerKey, $allowAnchor)
    {
        $this->setTrackerProperty($trackerKey, 'allowAnchor', $allowAnchor);
    }

    /**
     * @param string $trackerKey
     * @return boolean $allowAnchor (default:false)
     */
    public function getAllowAnchor($trackerKey)
    {
        if (null === ($property = $this->getTrackerProperty($trackerKey, 'allowAnchor'))) {
            return false;
        }

        return $property;
    }

    /**
     * @param string $trackerKey
     * @param boolean $allowHash
     */
    public function setAllowHash($trackerKey, $allowHash)
    {
        $this->setTrackerProperty($trackerKey, 'allowHash', $allowHash);
    }

    /**
     * @param string $trackerKey
     * @return boolean $allowHash (default:false)
     */
    public function getAllowHash($trackerKey)
    {
        if (null === ($property = $this->getTrackerProperty($trackerKey, 'allowHash'))) {
            return false;
        }

        return $property;
    }

    /**
     * @param string $trackerKey
     * @param boolean $allowLinker
     */
    public function setAllowLinker($trackerKey, $allowLinker)
    {
        $this->setTrackerProperty($trackerKey, 'allowLinker', $allowLinker);
    }

    /**
     * @param string $trackerKey
     * @return boolean $allowLinker (default:true)
     */
    public function getAllowLinker($trackerKey)
    {
        if (null === ($property = $this->getTrackerProperty($trackerKey, 'allowLinker'))) {
            return true;
        }

        return $property;
    }

    /**
     * @param string $trackerKey
     * @param boolean $includeNamePrefix
     */
    public function setIncludeNamePrefix($trackerKey, $includeNamePrefix)
    {
        $this->setTrackerProperty($trackerKey, 'includeNamePrefix', $includeNamePrefix);
    }

    /**
     * @param string $trackerKey
     * @return boolean $includeNamePrefix (default:true)
     */
    public function getIncludeNamePrefix($trackerKey)
    {
        if (null === ($property = $this->getTrackerProperty($trackerKey, 'includeNamePrefix'))) {
            return true;
        }

        return $property;
    }

    /**
     * @param string $trackerKey
     * @param boolean $name
     */
    public function setTrackerName($trackerKey, $name)
    {
        $this->setTrackerProperty($trackerKey, 'name', $name);
    }

    /**
     * @param string $trackerKey
     * @return string $name
     */
    public function getTrackerName($trackerKey)
    {
        return $this->getTrackerProperty($trackerKey, 'name');
    }

    /**
     * @param string $trackerKey
     * @param int $siteSpeedSampleRate
     */
    public function setSiteSpeedSampleRate($trackerKey, $siteSpeedSampleRate)
    {
        $this->setTrackerProperty($trackerKey, 'setSiteSpeedSampleRate', $siteSpeedSampleRate);
    }

    /**
     * @param string $trackerKey
     * @return int $siteSpeedSampleRate (default:null)
     */
    public function getSiteSpeedSampleRate($trackerKey)
    {
        if (null != ($property = $this->getTrackerProperty($trackerKey, 'setSiteSpeedSampleRate'))) {
            return (int)$property;
        }
    }

    /**
     * @return string $customPageView
     */
    public function getCustomPageView()
    {
        $customPageView = $this->container->get('session')->get(self::CUSTOM_PAGE_VIEW_KEY);
        $this->container->get('session')->remove(self::CUSTOM_PAGE_VIEW_KEY);

        return $customPageView;
    }

    /**
     * @return boolean $hasCustomPageView
     */
    public function hasCustomPageView()
    {
        return $this->has(self::CUSTOM_PAGE_VIEW_KEY);
    }

    /**
     * @param string $customPageView
     */
    public function setCustomPageView($customPageView)
    {
        $this->container->get('session')->set(self::CUSTOM_PAGE_VIEW_KEY, $customPageView);
    }

    /**
     * @param CustomVariable $customVariable
     */
    public function addCustomVariable(CustomVariable $customVariable)
    {
        $this->customVariables[] = $customVariable;
    }

    /**
     * @return array $customVariables
     */
    public function getCustomVariables()
    {
        return $this->customVariables;
    }

    /**
     * @return boolean $hasCustomVariables
     */
    public function hasCustomVariables()
    {
        if (!empty($this->customVariables)) {
            return true;
        }

        return false;
    }

    /**
     * @param Event $event
     */
    public function enqueueEvent(Event $event)
    {
        $this->add(self::EVENT_QUEUE_KEY, $event);
    }

    /**
     * @param array $eventQueue
     */
    public function getEventQueue()
    {
        return $this->getOnce(self::EVENT_QUEUE_KEY);
    }

    /**
     * @return boolean $hasEventQueue
     */
    public function hasEventQueue()
    {
        return $this->has(self::EVENT_QUEUE_KEY);
>>>>>>> 1a1a641f67d37c61a253d661a01add5aad2eef7f
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