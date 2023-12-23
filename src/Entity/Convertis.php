<?php



namespace App\Entity;

use App\Entity\Traits\Timestamp;
use App\Repository\ConvertisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ConvertisRepository::class)]
#[ORM\HasLifecycleCallbacks]
/**
 * @Vich\Uploadable
 */
class Convertis

{
    use Timestamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $ip;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $numero;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $instagram;

    /**
     * @Vich\UploadableField(mapping="convertis", fileNameProperty="avatar")
     * @var File|null
     * @Assert\Image(maxSize="10M", maxSizeMessage="Image trop volumineuse maximum 10Mb")
     * @Assert\Image(mimeTypes = {"image/jpeg", "image/jpg", "image/png"}, mimeTypesMessage = "Mauvais format d'image (jpeg, jpg et png)")
     **/
    private $imageFile;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $avatar;

    #[ORM\OneToMany(mappedBy: 'converti', targetEntity: Recurrence::class)]
    private $recurrences;

    #[ORM\Column(type: 'integer')]
    private $countRec;

    #[ORM\Column(type: 'boolean')]
    private $listeAttente;

    public function __construct()
    {
        $this->recurrences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;
        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(?string $numero): self
    {
        $this->numero = $numero;
        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): self
    {
        $this->instagram = $instagram;
        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * @return Collection|Recurrence[]
     */
    public function getRecurrences(): Collection
    {
        return $this->recurrences;
    }

    public function addRecurrence(Recurrence $recurrence): self
    {
        if (!$this->recurrences->contains($recurrence)) {
            $this->recurrences[] = $recurrence;
            $recurrence->setConverti($this);
        }
        return $this;
    }

    public function removeRecurrence(Recurrence $recurrence): self
    {
        if ($this->recurrences->removeElement($recurrence)) {
            // set the owning side to null (unless already changed)
            if ($recurrence->getConverti() === $this) {
                $recurrence->setConverti(null);
            }
        }
        return $this;
    }

    public function getCountRec(): ?int
    {
        return $this->countRec;
    }

    public function setCountRec(int $countRec): self
    {
        $this->countRec = $countRec;
        return $this;
    }

    public function getListeAttente(): ?bool
    {
        return $this->listeAttente;
    }

    public function setListeAttente(bool $listeAttente): self
    {
        $this->listeAttente = $listeAttente;
        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdated(new \DateTimeImmutable());
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
}
