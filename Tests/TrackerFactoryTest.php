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

//
//
//    /**
//     * @expectedException \InvalidArgumentException
//     */
//    public function testExpectedInvalidArgumentException()
//    {
//        $this->analytics->getAllowLinker('not-a-tracker');
//    }
//
//    /**
//     * @dataProvider providePageViewsForQueue
//     */
//    public function testEnqueuePageView($pageViews, $count)
//    {
//        foreach ($pageViews as $pageView) {
//            $this->analytics->enqueuePageView($pageView);
//        }
//
//        $this->assertTrue($this->analytics->hasPageViewQueue());
//        $this->assertEquals($count, count($this->analytics->getPageViewQueue()));
//    }
//
//    public function providePageViewsForQueue()
//    {
//        return array(
//            array(
//                array('/page-a', '/page-b', '/page-c'),
//                3
//            ),
//            array(
//                array('/page-y', '/page-z'),
//                2
//            )
//        );
//    }
//
//    /**
//     * @dataProvider provideEventsForQueue
//     */
//    public function testEnqueueEvent($eventData, $count)
//    {
//        foreach ($eventData as $data) {
//            $event = new Event($data['category'], $data['action']);
//            $this->analytics->enqueueEvent($event);
//        }
//
//        $this->assertTrue($this->analytics->hasEventQueue());
//        $this->assertEquals($count, count($this->analytics->getEventQueue()));
//    }
//
//    public function provideEventsForQueue()
//    {
//        return array(
//            array(
//                array(
//                    array('category' => 'Category A', 'action' => 'Action A'),
//                    array('category' => 'Category B', 'action' => 'Action B'),
//                    array('category' => 'Category C', 'action' => 'Action C')
//                ),
//                3
//            ),
//            array(
//                array(
//                    array('category' => 'Category D', 'action' => 'Action D'),
//                    array('category' => 'Category E', 'action' => 'Action E'),
//                ),
//                2
//            )
//        );
//    }
//
//    public function testSetGetTransaction()
//    {
//        $this->assertFalse($this->analytics->isTransactionValid());
//
//        $transaction = new Transaction();
//        $transaction->setOrderNumber('xxxx');
//        $transaction->setAffiliation('Store 777');
//        $transaction->setTotal(100.00);
//        $transaction->setTax(10.00);
//        $transaction->setShipping(5.00);
//        $transaction->setCity("NYC");
//        $transaction->setState("NY");
//        $transaction->setCountry("USA");
//        $this->analytics->setTransaction($transaction);
//
//        $this->assertTrue($this->analytics->isTransactionValid());
//        $this->assertEquals($transaction, $this->analytics->getTransaction());
//
//        $transaction = new Transaction();
//        $transaction->setAffiliation('Store 777');
//        $transaction->setTotal(100.00);
//        $transaction->setTax(10.00);
//        $transaction->setShipping(5.00);
//        $transaction->setCity("NYC");
//        $transaction->setState("NY");
//        $transaction->setCountry("USA");
//        $this->analytics->setTransaction($transaction);
//        $this->assertFalse($this->analytics->isTransactionValid());
//    }
//
//    public function testAddGetItems()
//    {
//        $item = new Item();
//        $item->setOrderNumber('xxxx');
//        $item->setSku('zzzz');
//        $item->setName('Product X');
//        $item->setCategory('Category A');
//        $item->setPrice(50.00);
//        $item->setQuantity(1);
//
//        $this->analytics->addItem($item);
//        $this->assertTrue($this->analytics->hasItem($item));
//
//        $item = new Item();
//        $item->setOrderNumber('bbbb');
//        $item->setSku('jjjj');
//        $item->setName('Product Y');
//        $item->setCategory('Category B');
//        $item->setPrice(25.00);
//        $item->setQuantity(2);
//
//        $this->analytics->addItem($item);
//        $this->assertTrue($this->analytics->hasItem($item));
//
//        $this->assertTrue($this->analytics->hasItems());
//        $this->assertEquals(2, count($this->analytics->getItems()));
//    }
//
//    public function testSetAllowAnchor()
//    {
//        $this->analytics->setAllowAnchor('default', false);
//        $this->assertFalse($this->analytics->getAllowAnchor('default'));
//    }
//
//    public function testSetAllowHash()
//    {
//        $this->analytics->setAllowHash('default', true);
//        $this->assertTrue($this->analytics->getAllowHash('default'));
//    }
//
//    public function testSetAllowLinker()
//    {
//        $this->analytics->setAllowLinker('default', false);
//        $this->assertFalse($this->analytics->getAllowLinker('default'));
//    }
//
//    public function testSetIncludeNamePrefix()
//    {
//        $this->analytics->setIncludeNamePrefix('default', false);
//        $this->assertFalse($this->analytics->getIncludeNamePrefix('default'));
//    }
//
//    public function testSetTrackerName()
//    {
//        $this->analytics->setTrackerName('default', 'a-different-name');
//        $this->assertEquals('a-different-name', $this->analytics->getTrackerName('default'));
//    }
//
//    public function testSetSiteSpeedSampleRate()
//    {
//        $this->assertNull($this->analytics->getSiteSpeedSampleRate('default'));
//        $this->analytics->setSiteSpeedSampleRate('default', '6');
//        $this->assertEquals(6, $this->analytics->getSiteSpeedSampleRate('default'));
//    }
}
