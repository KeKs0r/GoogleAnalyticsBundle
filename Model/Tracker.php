<?php
/**
 * Created by JetBrains PhpStorm.
 * User: marc
 * Date: 16.06.13
 * Time: 02:20
 * To change this template use File | Settings | File Templates.
 */
namespace Strego\GoogleBundle\Model;

use Strego\GoogleBundle\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @link https://developers.google.com/analytics/devguides/collection/analyticsjs/events
 */
class Tracker
{

    protected $accountID;
    protected $config = array();
    protected $pageViews = array();
    protected $events = array();
    protected $transaction;
    protected $metricDims = array();

    public function __construct($accountId)
    {
        $this->accountID = $accountId;
    }

    protected function getAllowedConfigKeys()
    {
        return array(
            'name',
            'accountId',
            'domain',
            'allowHash',
            'allowLinker',
            'trackPageLoadTime',
        );
    }

    public function set($key, $value)
    {
        if (!in_array($key, $this->getAllowedConfigKeys())) {
            throw new InvalidArgumentException(sprintf(
                "%key% is not a valid key, only: %valid%",
                $key,
                implode(',', $this->getAllowedConfigKeys())
            ));
        }

        $this->config[$key] = $value;
    }

    public function get($key){
        if(!array_key_exists($key, $this->config)){
            throw new InvalidArgumentException(sprintf(
                "%key% is does not exist, only: %valid%",
                $key,
                implode(',', array_keys($this->config))
            ));
        }

        return $this->config[$key];
    }

    public function setConfig($config){
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getAccountId(){
        return $this->accountID;
    }

    public function addPageView($pageView){
        $this->pageViews[] = $pageView;
    }

    public function getPageViews(){
        return $this->pageViews;
    }
    
    public function addEvent($event){
        $this->events[] = $event;
    }

    public function getEvents(){
        return $this->events;
    }
    
    public function setTransaction($transaction){
        $this->transaction = $transaction;
    }
    
    public function addItem($item){
        $this->transaction->addItem($item);
    }
    
    public function getTransactino(){
        return $this->transaction;
    }
    
    public function addMetricDim($metricDim){
        $this->metricDims[] = $metricDim;
    }
    
    public function getMetricDims(){
        return $this->metricDims;
    }





}