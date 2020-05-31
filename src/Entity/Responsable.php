<?php

namespace App\Entity;

use App\Repository\ResponsableRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\Timestampable;

/**
 * @ORM\Entity(repositoryClass=ResponsableRepository::class)
 */
class Responsable
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFokontany(): ?Fokontany
    {
        return $this->fokontany;
    }

    public function setFokontany(?Fokontany $fokontany): self
    {
        $this->fokontany = $fokontany;

        return $this;
    }

    public function getSalary(): ?string
    {
        return $this->salary;
    }

    public function setSalary(?string $salary): self
    {
        $this->salary = $salary;

        return $this;
    }
}
