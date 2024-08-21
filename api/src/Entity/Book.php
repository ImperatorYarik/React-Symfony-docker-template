<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Author $author = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $wroteAt = null;

    #[ORM\Column(length: 255)]
    private ?string $filePath = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    /**
     * @var Collection<int, PublishHouseBook>
     */
    #[ORM\OneToMany(targetEntity: PublishHouseBook::class, mappedBy: 'book')]
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getWroteAt(): ?\DateTimeImmutable
    {
        return $this->wroteAt;
    }

    public function setWroteAt(\DateTimeImmutable $wroteAt): static
    {
        $this->wroteAt = $wroteAt;

        return $this;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): static
    {
        $this->filePath = $filePath;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;

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
            $publishHouseBook->setBook($this);
        }

        return $this;
    }

    public function removePublishHouseBook(PublishHouseBook $publishHouseBook): static
    {
        if ($this->publishHouseBooks->removeElement($publishHouseBook)) {
            // set the owning side to null (unless already changed)
            if ($publishHouseBook->getBook() === $this) {
                $publishHouseBook->setBook(null);
            }
        }

        return $this;
    }
}
