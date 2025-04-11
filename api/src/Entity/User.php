<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Action\CreateUserAction;
use App\Action\GetUsersAction;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/registration',
            controller: CreateUserAction::class,
            normalizationContext: ['groups' => ['get:item:user']],
            denormalizationContext: ['groups' => ['post:collection:user']],
            security: "is_granted('PUBLIC_ACCESS')"
        ),
        new Get(
            normalizationContext: ['groups' => ['get:item:user']],
            security: "is_granted('" .User::ROLE_ADMIN. "') or is_granted('" .User::ROLE_USER. "') and object == user",
        ),
    ],
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ["email"], message: "Ця електронна пошта вже використовується")]
#[UniqueEntity(fields: ["phoneNumber"], message: "Цей номер телефону вже використовується")]
#[ApiFilter(SearchFilter::class, properties: [
    'id'          => "exact",
    "name"        => "start",
    "surname"     => "start",
    "lastname"    => "start",
    "email"       => "start",
    'phoneNumber' => 'exact',
    'address'     => "start",
])]
#[ApiFilter(OrderFilter::class, properties: [
    'id',
    'name',
    "surname",
    "lastname",
    'email',
    'phoneNumber',
    'address'
], arguments: ['orderParameterName' => 'order'])]
#[ApiFilter(BooleanFilter::class, properties: [
    "isActive",
])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_MANAGER = 'ROLE_MANAGER';

    /**
     * @var int|null
     */
    #[Id]
    #[GeneratedValue]
    #[Column]
    #[Groups([
        'get:item:user',
        'get:collection:user',
        'deserialize:token:user',
        'get:item:user:jwt',
    ])]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[Groups([
        'get:item:user',
        'get:collection:user',
        'get:item:user:jwt',
        'deserialize:token:user',
        'post:collection:user',
        'patch:item:user'
    ])]
    #[NotBlank(message: "Ім'я не може бути порожнім")]
    #[Type("string")]
    #[Length(min: 1, max: 255, minMessage: "Ім'я повинно містити щонайменше 1 символ", maxMessage: "Ім'я не може перевищувати 255 символів")]
    #[Column(length: 255)]
    private ?string $name = null;

    /**
     * @var string|null
     */
    #[Groups([
        'get:item:user',
        'get:collection:user',
        'get:item:user:jwt',
        'deserialize:token:user',
        'post:collection:user',
        'patch:item:user',
    ])]
    #[NotBlank(message: "Прізвище не може бути порожнім")]
    #[Type("string")]
    #[Length(min: 1, max: 255, minMessage: "Прізвище повинно містити щонайменше 1 символ", maxMessage: "Прізвище не може перевищувати 255 символів")]
    #[Column(length: 255)]
    private ?string $surname = null;

    /**
     * @var string|null
     */
    #[Groups([
        'get:item:user',
        'get:collection:user',
        'get:item:user:jwt',
        'deserialize:token:user',
        'post:collection:user',
        'patch:item:user'
    ])]
    #[Type("string")]
    #[Length(min: 1, max: 255, minMessage: "По батькові повинно містити щонайменше 1 символ", maxMessage: "По батькові не може перевищувати 255 символів")]
    #[NotBlank(message: "По батькові не може бути порожнім", allowNull: true)]
    #[Column(length: 255, nullable: true)]
    private ?string $lastName = null;

    /**
     * @var string|null
     */
    #[Groups([
        'get:item:user',
        'get:collection:user',
        'get:item:user:jwt',
        'deserialize:token:user',
        'post:collection:user',
        'patch:item:user'
    ])]
    #[NotBlank(message: "Електронна пошта не може бути порожньою")]
    #[Email(message: "Електронна пошта повинна бути валідною")]
    #[Column(length: 255)]
    private ?string $email = null;

    /**
     * @var string|null
     */
    #[Groups([
        'get:item:user',
        'get:collection:user',
        'post:collection:user',
        'deserialize:token:user',
        'patch:item:user'
    ])]
    #[NotBlank(message: "Номер телефону не може бути порожнім")]
    #[Type("string")]
    #[Regex(pattern: '/^(?:\d{10}|\+\d{12})$/', message: "Некорекний номер")]
    #[Column(length: 255)]
    private ?string $phoneNumber = null;

    /**
     * @var string|null
     */
    #[Groups([
        'post:collection:user'
    ])]
    #[Length(min: 4, max: 255, minMessage: "Пароль повинен містити щонайменше 4 символи", maxMessage: "Пароль не може перевищувати 255 символів")]
    #[Column(length: 255)]
    private ?string $password = null;

    /**
     * @var array
     */
    #[Groups([
        'get:item:user',
        'get:item:user:jwt',
        'deserialize:token:user',
        'get:collection:user'
    ])]
    #[Column]
    private array $roles = [];

    /**
     * @var bool|null
     */
    #[Groups([
        'get:item:user',
        'get:collection:user',
        'get:item:user:jwt',
        'deserialize:token:user',
        'patch:item:user'
    ])]
    #[Type("boolean")]
    #[Choice(choices: [true, false, null], message: "Статус активності повинен бути true, false або null")]
    #[Column(nullable: true)]
    private ?bool $isActive = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatar = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): void
    {
        $this->surname = $surname;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @return void
     */
    public function eraseCredentials(): void
    {}

    /**
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return $this->email ?? $this->phoneNumber;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }
}