<?php

namespace App\Entity;

use App\Repository\RecurrenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecurrenceRepository::class)]
class Recurrence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $adresseIP;

    #[ORM\Column(type: 'integer')]
    private $nombreVisite;

    #[ORM\ManyToOne(targetEntity: Convertis::class, inversedBy: 'recurrences')]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private $converti;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIp(): ?string
    {
        return $this->adresseIP;
    }

    public function setIp(string $adresseIP): self
    {
        $this->adresseIP = $adresseIP;

        return $this;
    }

    public function getNombreVisite(): ?int
    {
        return $this->nombreVisite;
    }

    public function setNombreVisite(int $nombreVisite): self
    {
        $this->nombreVisite = $nombreVisite;

        return $this;
    }

    public function getConverti(): ?Convertis
    {
        return $this->converti;
    }

    public function setConverti(?Convertis $converti): self
    {
        $this->converti = $converti;

        return $this;
    }
}
