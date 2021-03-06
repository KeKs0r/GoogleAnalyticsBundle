<?php

namespace Strego\GoogleBundle\Tests;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Strego\GoogleBundle\Analytics;
use Strego\GoogleBundle\Model\Event;
use Strego\GoogleBundle\Model\Item;
use Strego\GoogleBundle\Model\Transaction;
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
        $this->validateTemplate();
        $this->assertContains('ga(\'create\', \'xXxxXx\'', $output);
        $this->assertContains('"cookieDomain":".example.com"',$output);
        $this->assertContains('"allowHash":false',$output);
        $this->assertContains('"allowLinker":true',$output);
        $this->assertContains('"trackPageLoadTime":false',$output);
        $this->assertNotContains('"name":"default"', $output);
    }
    
    public function testOneTrackerNoPrefix(){
        $output = $this->template->render('StregoGoogleBundle:Analytics:async.html.twig');
        $this->validateTemplate(); 
        $this->assertContains("ga('send', 'pageview');",$output);
    }

    public function testPageViewOutput(){
        $this->analytics->addPageView('/testPage', 'testPageTitle');
        $this->analytics->addPageView('/test2Page', 'test2PageTitle');
        $output = $this->template->render('StregoGoogleBundle:Analytics:async.html.twig');
        $this->assertContains('/testPage',$output);
        $this->assertContains('testPageTitle',$output);
        $this->assertContains('/test2Page',$output);
        $this->assertContains('test2PageTitle',$output);
        
        $this->validateTemplate();
    }
    
    public function testEventOutput(){
        $this->analytics->addEvent('category1', 'action1');
        $output = $this->template->render('StregoGoogleBundle:Analytics:async.html.twig');
        $this->assertContains('category1',$output);
        $this->assertContains('action1',$output);   
        $this->validateTemplate();
    }
    
    public function testEventOutputWithMultipleEvents(){
        $this->analytics->addEvent('category1', 'action1');
        $this->analytics->addEvent('category2', 'action2', 'label2');
        $this->analytics->addEvent('category3', 'action3', 'label3', 1823);
        $output = $this->template->render('StregoGoogleBundle:Analytics:async.html.twig');

        $this->assertContains('category1',$output);
        $this->assertContains('action1',$output);
        
        
        $this->assertContains('category2',$output);
        $this->assertContains('action2',$output);
        $this->assertContains('label2',$output);
        
        
        $this->assertContains('category3',$output);
        $this->assertContains('action3',$output);
        $this->assertContains('label3',$output);
        $this->assertContains('1823',$output);
        
        
        $this->validateTemplate();    
    }
    
    public function testEcommerceOutPut(){
        
        $transaction = new Transaction('7238');
        $item1 = new Item();
        $item1->setPrice(12.43);
        $item1->setName('TestProduct');
        $transaction->addItem($item1);
         
        $this->analytics->setTransaction($transaction);
        $output = $this->template->render('StregoGoogleBundle:Analytics:async.html.twig');
        
        $this->assertContains("ga('require', 'ecommerce', 'ecommerce.js');",$output);
        $this->assertContains("ga('ecommerce:send');",$output);
        $this->assertContains("ga('ecommerce:addTransaction'",$output);
        $this->assertContains("TestProduct",$output);
        $this->assertContains("7238",$output);
        $this->assertContains("ga('ecommerce:addItem',",$output);
        $this->assertContains("12.43",$output);
        
        $this->validateTemplate();
    }
    
    
    protected function validateTemplate(){
        $twig = static::$kernel->getContainer()->get('twig');
        try {
            $twig->parse($twig->tokenize('StregoGoogleBundle:Analytics:async.html.twig'));
        } catch (\Twig_Error $e) {
           $this->fail('template linting failed');
        }
        //print($output);

    }





}
