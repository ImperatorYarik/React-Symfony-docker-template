<?php

namespace App\Entity;

use App\EntityListeners\UserEntityListener;
use Cassandra\Exception\ExecutionException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\EntityListeners;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;
use App\Validator\User as UserConstraint;


#[Entity]
#[EntityListeners([UserEntityListener::class])]
#[UniqueEntity('email', message: 'Пошта повинна бути унікальною!')]
#[UserConstraint]
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

    #[NotNull]
    #[NotBlank]
    #[Groups([
        'user:collection:get',
        'user:item:get',
        'user:collection:post',
    ])]
    #[Column(type: 'string', length: 255, nullable: false)]
    private string $name;

    #[NotNull]
    #[NotBlank]
    #[Email]
    #[Groups([
        'user:collection:get',
        'user:item:get',
        'user:collection:post',
    ])]
    #[Column(type: 'string', length: 255, unique: true)]
    private string $email;

    #[NotNull]
    #[NotBlank]
    #[Length(max: 255, min: 8)]
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

}
