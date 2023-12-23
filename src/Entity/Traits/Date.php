<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait Date
{

   #[ORM\Column(type: 'datetime')]
   private $date;

   public function getDate(): ?\DateTimeInterface
   {
      return $this->date;
   }

   public function setDate(\DateTimeInterface $date): self
   {
      $this->date = $date;

      return $this;
   }

   /**
    * Permet d'automatiser la date et de création et de modification
    */
   #[ORM\PrePersist]
   #[ORM\PreUpdate]
   public function updateTimestamps(): void
   {
      if ($this->getDate() === null) {
         $this->setDate(new \DateTimeImmutable());
      }
   }
}
