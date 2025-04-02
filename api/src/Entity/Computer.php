<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\ComputerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ComputerRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/computers',
            paginationItemsPerPage: 5,
            paginationMaximumItemsPerPage: 10,
            paginationClientItemsPerPage: true,
            normalizationContext: ['groups' => ['get:collection:computer']],
            security: "is_granted('ROLE_USER') && object.getUser === user"
        ),
        new Get(
            security: "is_granted('ROLE_USER') && object.getUser() === user"
        )
    ]
)]
#[ApiFilter(RangeFilter::class, properties: [
    'id',
])]
#[ApiFilter(OrderFilter::class, properties: [
    'id'
])]
#[ApiFilter(SearchFilter::class, properties: [
    'id',
    'name' => 'start'
])]
#[ApiFilter(BooleanFilter::class)]
class Computer
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'get:collection:user',
        'get:collection:computer'
    ])]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Groups([
        'get:collection:computer',
        'get:collection:user'
    ])]
    private ?string $name = null;

    /**
     * @var User|null
     */
    #[Groups([
        'get:collection:computer'
    ])]
    #[ORM\ManyToOne(inversedBy: 'computers')]
    private ?User $user = null;

    /**
     * @var string|null
     */
    #[Groups([
        'get:collection:computer',
        'get:collection:user'
    ])]
    #[ORM\Column(length: 255)]
    private ?string $serialNumber = null;

    #[ORM\Column]
    private ?bool $active = null;

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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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
    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
    }

    /**
     * @param string $serialNumber
     * @return $this
     */
    public function setSerialNumber(string $serialNumber): self
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }
}
