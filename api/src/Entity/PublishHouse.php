<?php

namespace App\Entity;

use App\Repository\PublishHouseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PublishHouseRepository::class)]
class PublishHouse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $foundedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $owner = null;

    /**
     * @var Collection<int, PublishHouseBook>
     */
    #[ORM\OneToMany(targetEntity: PublishHouseBook::class, mappedBy: 'publishHouse')]
    private Collection $publishHouseBooks;

    public function __construct()
    {
        $this->publishHouseBooks = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getFoundedAt(): ?\DateTimeImmutable
    {
        return $this->foundedAt;
    }

    public function setFoundedAt(\DateTimeImmutable $foundedAt): static
    {
        $this->foundedAt = $foundedAt;

        return $this;
    }

    public function getOwner(): ?string
    {
        return $this->owner;
    }

    public function setOwner(string $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, PublishHouseBook>
     */
    public function getPublishHouseBooks(): Collection
    {
        return $this->publishHouseBooks;
    }

    public function addPublishHouseBook(PublishHouseBook $publishHouseBook): static
    {
        if (!$this->publishHouseBooks->contains($publishHouseBook)) {
            $this->publishHouseBooks->add($publishHouseBook);
            $publishHouseBook->setPublishHouse($this);
        }

        return $this;
    }

    public function removePublishHouseBook(PublishHouseBook $publishHouseBook): static
    {
        if ($this->publishHouseBooks->removeElement($publishHouseBook)) {
            // set the owning side to null (unless already changed)
            if ($publishHouseBook->getPublishHouse() === $this) {
                $publishHouseBook->setPublishHouse(null);
            }
        }

        return $this;
    }
}
