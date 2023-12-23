<?php

namespace App\Entity;

use  App\Entity\Convertis;

class SearchConvertis
{

   /**
    * @var int
    */
   public $page = 1;

   /**
    * @var string
    */
   public $instagram = null;

   /**
    * @var string
    */
   public $numero = null;

   /**
    * @var bool
    */
   public $listeAttente;

   /**
    * @var DateTimeInterface|null
    */
   public $minDate = null;

   /**
    * @var DateTimeInterface|null
    */
   public $maxDate = null;

   /**
    * Get the value of instagram
    *
    * @return  string
    */
   public function getInstagram()
   {
      return $this->instagram;
   }

   /**
    * Get the value of numero
    *
    * @return  string
    */
   public function getNumero()
   {
      return $this->numero;
   }

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

   /**
    * Get the value of listeAttente
    *
    * @return  bool
    */ 
   public function getListeAttente()
   {
      return $this->listeAttente;
   }

   /**
    * Set the value of listeAttente
    *
    * @param  bool  $listeAttente
    *
    * @return  self
    */ 
   public function setListeAttente(?bool $listeAttente)
   {
      $this->listeAttente = $listeAttente;

      return $this;
   }
}
