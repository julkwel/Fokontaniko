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
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Doctrine\UuidGenerator;

/**
 * @ORM\Entity(repositoryClass=FokontanyRepository::class)
 */
class Fokontany
{
    use TimestampableEntity;

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
     * @ORM\OneToMany(targetEntity=Employee::class, mappedBy="fokontany", cascade={"all"})
     */
    private $responsables;

    /**
     * @ORM\OneToMany(targetEntity=Mponina::class, mappedBy="fokontany")
     */
    private $mponinas;

    /**
     * @ORM\OneToMany(targetEntity=History::class, mappedBy="fokontany")
     */
    private $histories;

    /**
     * Fokontany constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->responsables = new ArrayCollection();
        $this->mponinas = new ArrayCollection();
        $this->histories = new ArrayCollection();
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
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

    /**
     * @return Collection|Mponina[]
     */
    public function getMponinas(): Collection
    {
        return $this->mponinas;
    }

    public function addMponina(Mponina $mponina): self
    {
        if (!$this->mponinas->contains($mponina)) {
            $this->mponinas[] = $mponina;
            $mponina->setFokontany($this);
        }

        return $this;
    }

    public function removeMponina(Mponina $mponina): self
    {
        if ($this->mponinas->contains($mponina)) {
            $this->mponinas->removeElement($mponina);
            // set the owning side to null (unless already changed)
            if ($mponina->getFokontany() === $this) {
                $mponina->setFokontany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|History[]
     */
    public function getHistories(): Collection
    {
        return $this->histories;
    }

    public function addHistory(History $history): self
    {
        if (!$this->histories->contains($history)) {
            $this->histories[] = $history;
            $history->setFokontany($this);
        }

        return $this;
    }

    public function removeHistory(History $history): self
    {
        if ($this->histories->contains($history)) {
            $this->histories->removeElement($history);
            // set the owning side to null (unless already changed)
            if ($history->getFokontany() === $this) {
                $history->setFokontany(null);
            }
        }

        return $this;
    }
}
