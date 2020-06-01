<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany entity.
 */

namespace App\Entity;

use App\Repository\FokontanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FokontanyRepository::class)
 */
class Fokontany
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $codeFkt;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="fokontany")
     */
    private $users;

    /**
     * @ORM\OneToOne(targetEntity=Employee::class, mappedBy="fokontany", cascade={"persist", "remove"})
     */
    private $responsable;

    /**
     * Fokontany constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCodeFkt(): ?string
    {
        return $this->codeFkt;
    }

    /**
     * @param string $codeFkt
     *
     * @return $this
     */
    public function setCodeFkt(string $codeFkt): self
    {
        $this->codeFkt = $codeFkt;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setFokontany($this);
        }

        return $this;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getFokontany() === $this) {
                $user->setFokontany(null);
            }
        }

        return $this;
    }

    public function getResponsable(): ?Responsable
    {
        return $this->responsable;
    }

    public function setResponsable(?Responsable $responsable): self
    {
        $this->responsable = $responsable;

        // set (or unset) the owning side of the relation if necessary
        $newFokontany = null === $responsable ? null : $this;
        if ($responsable->getFokontany() !== $newFokontany) {
            $responsable->setFokontany($newFokontany);
        }

        return $this;
    }
}
