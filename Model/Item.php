<?php

namespace Strego\GoogleBundle\Model;

class Item
{
    
    public $id;
    public $name;
    public $sku;
    public $category;
    public $price;
    public $quantity;
    
    public function setId($id){
        $this->id = $id;
    }
    
    public function getId(){
        return $this->id;
    }
    

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setName($name)
    {
        $this->name = (string) $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPrice($price)
    {
        $this->price = (float) $price;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setSku($sku)
    {
        $this->sku = (string) $sku;
    }

    public function getSku()
    {
        return $this->sku;
    }
}
