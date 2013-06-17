<?php

namespace Strego\GoogleBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 */
class PageView
{

   public $page;
   public $title;

   public function __construct($page, $title = null){
       $this->page = $page;
       $this->title = $title;
   }

    public function getPage(){
        return $this->page;
    }

    public function getTitle(){
        $this->title;
    }

}
