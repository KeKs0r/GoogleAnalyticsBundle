<?php

namespace Strego\GoogleBundle\Model;

class Transaction
{
    
    /**
     *  Transaction ID (required)
     */
    private $id;
    
    /**
     * Affiliation or store name
     */
    private $affiliation;
    
    /**
     * Grand Total
     */ 
    private $revenue;
    
    /**
     * Shipping Costs
     */ 
    private $shipping;
    
    /**
     * Taxes
     */ 
    private $tax;
    
    /**
     * If this transaction ahs another currency than the default
     */ 
    private $currencyCode;
    
    protected $items = array();
    
    public function __construct($id, $affiliation = null, $revenue = null, $shipping = null, $tax = null){
        $this->id = $id;
        $this->affiliation = $affiliation;
        $this->revenue = $revenue;
        $this->shipping = $shipping;
        $this->tax = $tax;
    }
    
    public function getId(){
        return $this->id;
    }

    public function setAffiliation($affiliation)
    {
        $this->affiliation = (string) $affiliation;
    }

    public function getAffiliation()
    {
        return $this->affiliation;
    }
    
    public function setRevenue($revenue)
    {
        $this->revenue = $revenue;
    }

    public function getRevenue()
    {
        return $this->revenue;
    }

    public function setShipping($shipping)
    {
        $this->shipping = (float) $shipping;
    }

    public function getShipping()
    {
        return $this->shipping;
    }

    public function setTax($tax)
    {
        $this->tax = (float) $tax;
    }

    public function getTax()
    {
        return $this->tax;
    }
    
    public function addItem($item){
        $item->setId($this->getId());
        $this->items[] = $item;
    }
    
    public function getItems(){
        return $this->items();
    }

}
