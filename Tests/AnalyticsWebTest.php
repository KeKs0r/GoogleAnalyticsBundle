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

    public function testStandardOutput(){
        $output = $this->template->render('StregoGoogleBundle:Analytics:async.html.twig');
        $this->assertContains('ga(\'create\', \'xXxxXx\'', $output);
        $this->assertContains('"cookieDomain":".example.com"',$output);
        $this->assertContains('"allowHash":false',$output);
        $this->assertContains('"allowLinker":true',$output);
        $this->assertContains('"trackPageLoadTime":false',$output);
        $this->assertNotContains('"name":"default"', $output);
    }

    public function testPageViewOutput(){
        $this->analytics->addPageView('/testPage', 'testPageTitle');
        $this->analytics->addPageView('/test2Page', 'test2PageTitle');
        $output = $this->template->render('StregoGoogleBundle:Analytics:async.html.twig');
        $this->assertContains('/testPage',$output);
        $this->assertContains('testPageTitle',$output);
        $this->assertContains('/test2Page',$output);
        $this->assertContains('test2PageTitle',$output);
        print($output);
    }





}
