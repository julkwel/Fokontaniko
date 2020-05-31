<?php
/**
 * © Julkwel <julienrajerison5@gmail.com>
 *
 * Fokontany entity.
 */

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fullName;

    /**
     * @ORM\ManyToOne(targetEntity=Fokontany::class, inversedBy="users")
     */
    private $fokontany;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $contact;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="text")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $userName;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAlive;

    /**
     * @ORM\Column(type="string", length=20,nullable=true)
     */
    private $cin;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->isAlive = true;
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
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastname
     *
     * @return $this
     */

    public function setLastName(?string $lastname): self
    {
        $this->lastName = $lastname;

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
     * @param string|null $firstName
     *
     * @return $this
     */
    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    /**
     * @param string|null $fullName
     *
     * @return $this
     */
    public function setFullName(?string $fullName): self
    {
        $this->fullName = $this->firstName.' '.$this->lastName;

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
     * @return string|null
     */
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     *
     * @return $this
     */
    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }


    /**
     * @param array $roles
     *
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $userName
     *
     * @return $this
     */
    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

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
     * @inheritDoc
     */
    public function getRoles()
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->userName;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
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
}
