<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany entity.
 */

namespace App\Entity;

use App\Repository\MponinaRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=MponinaRepository::class)
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Mponina
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @var UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAlive;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $type;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $function;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $dad;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $mum;

    /**
     * @ORM\ManyToOne(targetEntity=Fokontany::class, inversedBy="mponinas")
     */
    private $fokontany;

    /**
     * @var string|null
     *
     * @ORM\Column(type="boolean", options={"default": true})
     */
    private $isNew;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $cin;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contact;

    /**
     * @ORM\OneToMany(targetEntity=Adidy::class, mappedBy="user")
     */
    private $adidies;

    /**
     * @ORM\Column(type="integer", length=2, nullable=true)
     */
    private $genres;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthDate;

    /**
     * Mponina constructor.
     */
    public function __construct()
    {
        $this->isAlive = true;
        $this->isNew = true;
        $this->adidies = new ArrayCollection();
    }

    /**
     * @return UuidInterface|null
     */
    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getDad(): ?string
    {
        return $this->dad;
    }

    /**
     * @param string|null $dad
     *
     * @return Mponina
     */
    public function setDad(?string $dad): self
    {
        $this->dad = $dad;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMum(): ?string
    {
        return $this->mum;
    }

    /**
     * @param string|null $mum
     *
     * @return Mponina
     */
    public function setMum(?string $mum): self
    {
        $this->mum = $mum;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return $this
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     *
     * @return $this
     */
    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName(): ?string
    {
        return $this->firstName.' '.$this->lastName;
    }

    /**
     * @return string|null
     */
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    /**
     * @param string|null $adresse
     *
     * @return $this
     */
    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return bool|null
     */

    public function getIsAlive(): ?bool
    {
        return $this->isAlive;
    }

    /**
     * @param bool $isAlive
     *
     * @return $this
     */
    public function setIsAlive(bool $isAlive): self
    {
        $this->isAlive = $isAlive;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFunction(): ?string
    {
        return $this->function;
    }

    /**
     * @param string|null $function
     *
     * @return $this
     */
    public function setFunction(?string $function): self
    {
        $this->function = $function;

        return $this;
    }

    /**
     * @return Fokontany|null
     */
    public function getFokontany(): ?Fokontany
    {
        return $this->fokontany;
    }

    /**
     * @param Fokontany|null $fokontany
     *
     * @return $this
     */
    public function setFokontany(?Fokontany $fokontany): self
    {
        $this->fokontany = $fokontany;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIsNew(): ?string
    {
        return $this->isNew;
    }

    /**
     * @param string|null $isNew
     *
     * @return Mponina
     */
    public function setIsNew(?string $isNew): Mponina
    {
        $this->isNew = $isNew;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNote(): ?string
    {
        return $this->note;
    }

    /**
     * @param string|null $note
     *
     * @return $this
     */
    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCin(): ?string
    {
        return $this->cin;
    }

    /**
     * @param string|null $cin
     *
     * @return $this
     */
    public function setCin(?string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContact(): ?string
    {
        return $this->contact;
    }

    /**
     * @param string|null $contact
     *
     * @return $this
     */
    public function setContact(?string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @return Collection|Adidy[]
     */
    public function getAdidies(): Collection
    {
        return $this->adidies;
    }

    /**
     * @param Adidy $adidy
     *
     * @return $this
     */
    public function addAdidy(Adidy $adidy): self
    {
        if (!$this->adidies->contains($adidy)) {
            $this->adidies[] = $adidy;
            $adidy->setUser($this);
        }

        return $this;
    }

    /**
     * @param Adidy $adidy
     *
     * @return $this
     */
    public function removeAdidy(Adidy $adidy): self
    {
        if ($this->adidies->contains($adidy)) {
            $this->adidies->removeElement($adidy);
            // set the owning side to null (unless already changed)
            if ($adidy->getUser() === $this) {
                $adidy->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return int|null
     */
    public function getGenres(): ?int
    {
        return $this->genres;
    }

    /**
     * @param int|null $genres
     *
     * @return $this
     */
    public function setGenres(?int $genres): self
    {
        $this->genres = $genres;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getBirthDate(): ?DateTimeInterface
    {
        return $this->birthDate;
    }

    /**
     * @param DateTimeInterface|null $birthDate
     *
     * @return $this
     */
    public function setBirthDate(?DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }
}
