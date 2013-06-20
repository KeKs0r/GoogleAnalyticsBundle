<?php

namespace Strego\GoogleBundle\Helper;

use Strego\GoogleBundle\Analytics;
use Strego\GoogleBundle\Model\Event;
use Symfony\Component\Templating\Helper\Helper;

class AnalyticsHelper extends Helper
{
    /**
     * @var \Strego\GoogleBundle\Analytics
     */
    private $analytics;


    public function __construct(Analytics $analytics)
    {
        $this->analytics = $analytics;
    }

    public function getTrackers()
    {
        return $this->analytics->getTrackers();
        $ret = array();
        foreach($this->analytics->getTrackers() as $tracker){
            if($tracker->get('name') == $this->getDefaultTracker()){
                $tracker->reset('name');
            }
            $ret[] = $tracker;
        }
        return $ret;
    }

    public function getDefaultTracker(){
        return $this->analytics->getDefaultTracker();
    }













    public function getAllowAnchor($trackerKey)
    {
        return $this->analytics->getAllowAnchor($trackerKey);
    }

    public function getAllowHash($trackerKey)
    {
        return $this->analytics->getAllowHash($trackerKey);
    }

    public function getAllowLinker($trackerKey)
    {
        return $this->analytics->getAllowLinker($trackerKey);
    }

    public function getTrackerName($trackerKey)
    {
        if ($this->analytics->getIncludeNamePrefix($trackerKey)) {
            return $this->analytics->getTrackerName($trackerKey).'.';
        }
        return "";
    }

    public function getSiteSpeedSampleRate($trackerKey)
    {
        return $this->analytics->getSiteSpeedSampleRate($trackerKey);
    }

    public function hasCustomPageView()
    {
        return $this->analytics->hasCustomPageView();
    }

    public function getCustomPageView()
    {
        return $this->analytics->getCustomPageView();
    }

    public function hasCustomVariables()
    {
        return $this->analytics->hasCustomVariables();
    }

    public function getCustomVariables()
    {
        return $this->analytics->getCustomVariables();
    }

    public function hasEventQueue()
    {
        return $this->analytics->hasEventQueue();
    }

    public function getEventQueue()
    {
        return $this->analytics->getEventQueue();
    }

    public function hasItems()
    {
        return $this->analytics->hasItems();
    }

    public function getItems()
    {
        return $this->analytics->getItems();
    }

    public function getRequestUri()
    {
        return $this->analytics->getRequestUri();
    }

    public function hasPageViewQueue()
    {
        return $this->analytics->hasPageViewQueue();
    }

    public function getPageViewQueue()
    {
        return $this->analytics->getPageViewQueue();
    }

    public function getSourceHttps()
    {
        return $this->sourceHttps;
    }

    public function getSourceHttp()
    {
        return $this->sourceHttp;
    }

    public function getSourceEndpoint()
    {
        return $this->sourceEndpoint;
    }


    
    public function getApiKey()
    {
        return $this->analytics->getApiKey();
    }
    
    public function getClientId()
    {
        return $this->analytics->getClientId();
    }
    
    public function getTableId()
    {
        return $this->analytics->getTableId();
    }

    public function isTransactionValid()
    {
        return $this->analytics->isTransactionValid();
    }

    public function getTransaction()
    {
        return $this->analytics->getTransaction();
    }

    public function getName()
    {
        return 'google_analytics';
    }
}
