<?php

namespace App\Entity;

use App\EntityListener\UserEntityListener;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints\Email;



#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    const ROLE_USER= 'ROLE_USER';
    const ROLE_ADMIN= 'ROLE_ADMIN';
    const ROLE_MANAGER= 'ROLE_MANAGER';
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(["user:read"])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;
    #[Groups(["user:read"])]
    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[Email]
    #[Groups(["user:read"])]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $roles = [];


    #[ORM\PrePersist]
    public function changeName(): void
    {
        $this->name= "TEST";
    }
    public function __construct()
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRole(string $role): static
    {
        if (!in_array($role, $this->roles)) {
            $this->roles[] = $role;
        }

        return $this;
    }


    public function getUserIdentifier(): string
    {
        return $this->email;
    }


    public function eraseCredentials(): void
    {

    }

}