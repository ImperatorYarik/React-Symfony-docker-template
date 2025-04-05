<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Action\UserCreateAction;
use App\Action\UserUpdateAction;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[Entity(repositoryClass: UserRepository::class)]
#[UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['get:collection:user']],
            security: 'is_granted("ROLE_USER") && is_granted("ROLE_ADMIN")',
        ),
        new Get(
            security: "is_granted('ROLE_ADMIN') && object.getId() === user.getId()"
        ),
        new Post(
            uriTemplate: '/registration',
            controller: UserCreateAction::class,
            normalizationContext: ['groups' => ['get:collection:user']],
            denormalizationContext: ['groups' => ['post:collection:user']],
        ),
        new Put(
            controller: UserUpdateAction::class,
        ),
        new Patch(
            controller: UserUpdateAction::class,
        ),
        new Delete()
    ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    /**
     *
     */
    public const ROLE_USER = 'ROLE_USER';
    /**
     *
     */
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[Groups([
        'get:collection:user',
        'post:collection:user',
        'get:collection:computer'
    ])]
    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[Groups([
        'get:collection:user',
        'get:collection:computer'
    ])]
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string|null
     */
    #[Groups([
        'post:collection:user',
    ])]
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var bool|null
     */
    #[ORM\Column]
    private ?bool $active = null;

    /**
     * @var string
     */
    #[ORM\Column]
    private string $createdAt;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::STRING)]
    private ?string $visitedAt = null;

    /**
     * @var Collection<int, Computer>
     */
    #[Groups([
        'get:collection:user',
    ])]
    #[ORM\OneToMany(targetEntity: Computer::class, mappedBy: 'user')]
    private Collection $computers;

    /**
     *
     */
    public function __construct()
    {
        $this->computers = new ArrayCollection();
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
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection<int, Computer>
     */
    public function getComputers(): Collection
    {
        return $this->computers;
    }

    /**
     * @param Computer $computer
     * @return $this
     */
    public function addComputer(Computer $computer): static
    {
        if (!$this->computers->contains($computer)) {
            $this->computers->add($computer);
            $computer->setUser($this);
        }

        return $this;
    }

    /**
     * @param Computer $computer
     * @return $this
     */
    public function removeComputer(Computer $computer): static
    {
        if ($this->computers->removeElement($computer)) {
            // set the owning side to null (unless already changed)
            if ($computer->getId() === $this) {
                $computer->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @param int|null $id
     * @return $this
     */
    public function setId(?int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function isActive(): ?bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return $this
     */
    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     * @return void
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string|null
     */
    public function getVisitedAt(): ?string
    {
        return $this->visitedAt;
    }

    /**
     * @param string $visitedAt
     * @return $this
     */
    public function setVisitedAt(string $visitedAt): self
    {
        $this->visitedAt = $visitedAt;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

}
