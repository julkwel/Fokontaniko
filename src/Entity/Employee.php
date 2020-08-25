<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany entity.
 */

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Doctrine\UuidGenerator;

/**
 * @ORM\Entity(repositoryClass=EmployeeRepository::class)
 */
class Employee
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
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $salary;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $post;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity=Fokontany::class, inversedBy="responsables")
     */
    private $fokontany;

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
    public function getSalary(): ?string
    {
        return $this->salary;
    }

    /**
     * @param string|null $salary
     *
     * @return $this
     */
    public function setSalary(?string $salary): self
    {
        $this->salary = $salary;

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
     * @return string
     */
    public function getPost(): ?string
    {
        return $this->post;
    }

    /**
     * @param string|null $post
     *
     * @return Employee
     */
    public function setPost(?string $post): Employee
    {
        $this->post = $post;

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
     * @return Employee
     */
    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }
}
