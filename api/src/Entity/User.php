<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Action\UserAction;
use App\Controller\UserController;
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

#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['user:get']]),
        //new GetCollection(normalizationContext: ['groups' => ['user:get']], security: "is_granted('ROLE_USER')"),
        new GetCollection(),
        new Post(normalizationContext: ['groups' => ['user:get']], denormalizationContext: ['groups' => ['user:post']], controller: UserAction::class),
    ]
)]
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

    #[Groups([
        'user:get',
        'user:post',
    ])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;
    #[Groups([
        'user:post',
    ])]
    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    #[Groups([
        'user:post',
        'user:get',
    ])]
    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[Groups([
        'user:get',
        'user:post',
    ])]
    #[Email]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $roles = [];

    /**
     * @var Collection<int, Order>
     */
    #[Groups([
        'user:get'
    ])]
    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'user')]
    private Collection $orders;


    #[ORM\PrePersist]
    public function changeName(): void
    {
        $this->name= "TEST";
    }
    public function __construct()
    {
        $this->orders = new ArrayCollection();
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

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

        return $this;
    }

}