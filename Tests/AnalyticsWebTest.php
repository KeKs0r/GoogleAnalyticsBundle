<?php

namespace Strego\GoogleBundle\Tests;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Strego\GoogleBundle\Analytics;
use Strego\GoogleBundle\Analytics\Event;
use Strego\GoogleBundle\Analytics\Item;
use Strego\GoogleBundle\Analytics\Transaction;
use Symfony\Component\Form\Extension\Templating\TemplatingRendererEngine;

class AnalyticsWebTest extends WebTestCase
{
    /**
     * @var
     */
    private $template;

    private $client;

    /**
     * @var Analytics
     */
    private $analytics;

    protected function setUp()
    {
        parent::setUp();
        static::createClient();
        $this->template = static::$kernel->getContainer()->get('templating');
        $this->analytics = static::$kernel->getContainer()->get('strego_google');
    }

    protected function tearDown()
    {
        $this->analytics = null;
        $this->client = null;
        parent::tearDown();
    }

    public function testOutPut(){
        //$this->analytics->getTracker()
        print($this->template->render('StregoGoogleBundle:Analytics:async.html.twig'));
    }




}
