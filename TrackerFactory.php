<?php

namespace Strego\GoogleBundle;


use Strego\GoogleBundle\Model\Tracker;

class TrackerFactory
{

    /**
     * @var array
     */
    private $trackerConfigs = array();

    private $defaultTracker;

    /**
     * @var array;
     */
    private $trackers = array();

    /**
     * @param array $connections
     */
    public function __construct(array $trackerConfigs = array(), $defaultTracker)
    {
        $this->trackerConfigs = $trackerConfigs;
        $this->defaultTracker = $defaultTracker;
    }

    /**
     * @param string $name
     * @throws \RuntimeException if there are no connections
     * @throws \InvalidArgumentException if the given connection name is unknown
     * @return Tracker
     */
    public function getTracker($name = null)
    {
        if ($name == null) {
            $name = $this->getDefaultTracker();
        }

        if (count($this->trackerConfigs) == 0) {
            throw new \RuntimeException('No trackers found');
        }

        if (!array_key_exists($name, $this->trackerConfigs)) {
            throw new \InvalidArgumentException(sprintf('Unknown tracker %s', $name));
        }

        if (!array_key_exists($name, $this->trackers)) {
            $trackerConfig = $this->trackerConfigs[$name];

            $this->trackers[$name] = $this->createTracker($name, $trackerConfig);
        }

        return $this->trackers[$name];
    }

    public function getTrackers()
    {
        $trackers = array();
        foreach ($this->trackerConfigs as $name => $conf) {
            $trackers[$name] = $this->getTracker($name);
        }
        return $trackers;
    }


    /**
     * Create a tracker by config
     *
     * @param array $config
     *
     * @return Tracker
     */
    public function createTracker($name, $config = null)
    {
        $tracker = new Tracker($config['accountId']);
        unset($config['accountId']);
        $config['name'] = $name;
        $tracker->setConfig($config);

        return $tracker;
    }

    public function getDefaultTracker(){
        return $this->defaultTracker;
    }


}