<?php

namespace App\Entity;

use App\Repository\VisiteRecRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisiteRecRepository::class)]
#[ORM\HasLifecycleCallbacks]
class VisiteRec
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $adresseIPRec;

    #[ORM\Column(type: 'datetime')]
    private $dateRec;

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
        return $this->dateRec;
    }

    public function setDate(\DateTimeInterface $dateRec): self
    {
        $this->dateRec = $dateRec;

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
