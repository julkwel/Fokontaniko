<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany entity.
 */

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployeeRepository::class)
 */
class Employee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=Fokontany::class, inversedBy="responsable", cascade={"persist", "remove"})
     */
    private $fokontany;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $salary;

    /**
     * @return int|null
     */
    public function getId(): ?int
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
}
