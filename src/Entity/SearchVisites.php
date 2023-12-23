<?php

namespace App\Entity;

use  App\Entity\Convertis;

class SearchVisites
{

   /**
    * @var int
    */
   public $page = 1;

   /**
    * @var DateTimeInterface|null
    */
   public $minDate = null;

   /**
    * @var DateTimeInterface|null
    */
   public $maxDate = null;

   /**
    * Get the value of minDate
    *
    * @return  DateTimeInterface|null
    */ 
   public function getMinDate()
   {
      return $this->minDate;
   }

   /**
    * Get the value of maxDate
    *
    * @return  DateTimeInterface|null
    */ 
   public function getMaxDate()
   {
      return $this->maxDate;
   }
}
