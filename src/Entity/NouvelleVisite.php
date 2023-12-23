<?php

namespace App\Entity;

use App\Repository\NouvelleVisiteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NouvelleVisiteRepository::class)]
#[ORM\HasLifecycleCallbacks]
class NouvelleVisite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $adresseIPRec;

    #[ORM\Column(type: 'datetime')]
    private $dateNv;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIp(): ?string
    {
        return $this->adresseIPRec;
    }

    public function setIp(string $adresseIPRec): self
    {
        $this->adresseIPRec = $adresseIPRec;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->dateNv;
    }

    public function setDate(\DateTimeInterface $dateNv): self
    {
        $this->dateNv = $dateNv;

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
