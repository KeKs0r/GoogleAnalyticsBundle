<?php

namespace Strego\GoogleBundle\Tests;

use DateTime;
use Strego\GoogleBundle\TrackerFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Strego\GoogleBundle\Analytics;
use Strego\GoogleBundle\Model\Event;
use Strego\GoogleBundle\Model\Item;
use Strego\GoogleBundle\Model\Transaction;

class TrackerFactoryTest extends WebTestCase
{
    /**
     * @var TrackerFactory
     */
    private $factory;
    private $client;

    protected function setUp()
    {
        parent::setUp();
        $this->client = static::createClient();

        $analytics = static::$kernel->getContainer()->get('strego_google');

        $reflectionProperty = new \ReflectionProperty(get_class($analytics), "trackerFactory");
        $reflectionProperty->setAccessible(true);
        $this->factory =  $reflectionProperty->getValue($analytics);
    }

    protected function tearDown()
    {
        $this->factory = null;
        $this->client = null;
        parent::tearDown();
    }
    
    public function testGetTrackerWithoutParameterIsDefault(){
        $def = $this->factory->getDefaultTracker();
        $tracker = $this->factory->getTracker();
        $this->assertEquals($def, $tracker->get('name'));
    }


    public function testGetTrackers(){
        $trackers = $this->factory->getTrackers();
        $this->assertCount(1,$trackers);
        $this->assertTrue(is_array($trackers));
    }
}
