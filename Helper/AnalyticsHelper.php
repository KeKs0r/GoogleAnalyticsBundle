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
        //return $this->analytics->getTrackers();
        $ret = array();
        $trackers = $this->analytics->getTrackers();
        foreach($trackers as $tracker){
            if($tracker->get('name') == $this->getDefaultTracker() AND count($tracker) == 1){
                $tracker->reset('name');
            }
            $ret[] = $tracker;
        }
        return $ret;
    }

    public function getDefaultTracker(){
        return $this->analytics->getDefaultTracker();
    }


    public function getName()
    {
        return 'google_analytics';
    }
}
