<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany Entity.
 */

namespace App\Entity;

use App\Repository\HistoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Doctrine\UuidGenerator;

/**
 * @ORM\Entity(repositoryClass=HistoryRepository::class)
 */
class History
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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="histories")
     */
    private $user;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $action;

    /**
     * @ORM\ManyToOne(targetEntity=Fokontany::class, inversedBy="histories")
     */
    private $fokontany;

    /**
     * @ORM\Column(type="integer", length=10, nullable=true)
     */
    private $type;

    /**
     * @return UuidInterface|null
     */
    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     *
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAction(): ?string
    {
        return $this->action;
    }

    /**
     * @param string|null $action
     *
     * @return $this
     */
    public function setAction(?string $action): self
    {
        $this->action = $action;

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
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * @param int $type
     *
     * @return $this
     */
    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }
}
