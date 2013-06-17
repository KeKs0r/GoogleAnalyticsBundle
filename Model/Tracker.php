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
    protected $name;
    protected $domain;
    protected $allowHash;
    protected $allowLinker;
    protected $trackPageLoadTime;

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



}