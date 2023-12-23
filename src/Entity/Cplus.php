<?php

namespace App\Entity;

use App\Entity\Traits\Date;
use App\Repository\CplusRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CplusRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Cplus
{
    use Date;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean')]
    private $soldOut;

    #[ORM\Column(type: 'string', length: 255)]
    private $statut;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSoldOut(): ?bool
    {
        return $this->soldOut;
    }

    public function setSoldOut(bool $soldOut): self
    {
        $this->soldOut = $soldOut;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }
}
