<?php

namespace Strego\GoogleBundle\Helper;

use Strego\GoogleBundle\Analytics;
use Strego\GoogleBundle\Model\Event;
use Symfony\Component\Templating\Helper\Helper;

class AnalyticsHelper extends Helper
{
    private $analytics;


    public function __construct(Analytics $analytics)
    {
        $this->analytics = $analytics;
    }

    public function getTrackers()
    {
        return $this->analytics->getTrackers();
    }


    public function getName()
    {
        return 'google_analytics';
    }
}
