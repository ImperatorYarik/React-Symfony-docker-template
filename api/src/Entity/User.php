<?php

namespace App\Entity;

use App\EntityListeners\UserEntityListener;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\EntityListeners;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[Entity]
#[EntityListeners([UserEntityListener::class])]
class User
{

    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    #[Id]
    #[Column]
    #[GeneratedValue]
    #[Groups([
        'user:collection:get',
        'user:item:get',
    ])]
    private int $id;

    #[Groups([
        'user:collection:get',
        'user:item:get',
        'user:collection:post',
    ])]
    #[Column(type: 'string', length: 255, nullable: true)]
    private string $myName;

    #[Groups([
        'user:collection:get',
        'user:item:get',
        'user:collection:post',
    ])]
    #[Column(type: 'string', length: 255, unique: true)]
    private string $email;

    #[Groups([
        'user:collection:get',
        'user:item:get',
        'user:collection:post',
    ])]
    #[Column(type: 'string', length: 255)]
    private string $password;

    #[Groups([
        'user:collection:get',
        'user:item:get',
        'user:collection:post',
    ])]
    #[Column(type: Types::ARRAY)]
    private ?array $roles = [];

    public function getId(): int
    {
        return $this->id;
    }

    public function getMyName(): string
    {
        return $this->myName;
    }

    public function setMyName(string $myName): User
    {
        $this->myName = $myName;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;
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

}