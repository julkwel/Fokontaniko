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
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Doctrine\UuidGenerator;

/**
 * @ORM\Entity(repositoryClass=FokontanyRepository::class)
 */
class Fokontany
{
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
     * @ORM\OneToMany(targetEntity=Employee::class, mappedBy="fokontany")
     */
    private $responsables;

    /**
     * Fokontany constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->responsables = new ArrayCollection();
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

    /**
     * @return Collection|Employee[]
     */
    public function getResponsables(): Collection
    {
        return $this->responsables;
    }

    /**
     * @param Employee $responsable
     *
     * @return $this
     */
    public function addResponsable(Employee $responsable): self
    {
        if (!$this->responsables->contains($responsable)) {
            $this->responsables[] = $responsable;
            $responsable->setFokontany($this);
        }

        return $this;
    }

    /**
     * @param Employee $responsable
     *
     * @return $this
     */
    public function removeResponsable(Employee $responsable): self
    {
        if ($this->responsables->contains($responsable)) {
            $this->responsables->removeElement($responsable);
            // set the owning side to null (unless already changed)
            if ($responsable->getFokontany() === $this) {
                $responsable->setFokontany(null);
            }
        }

        return $this;
    }
}
