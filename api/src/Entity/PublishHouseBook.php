<?php

namespace App\Entity;

use App\Repository\PublishHouseBookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PublishHouseBookRepository::class)]
class PublishHouseBook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'publishHouseBooks')]
    private ?Book $book = null;

    #[ORM\ManyToOne(inversedBy: 'publishHouseBooks')]
    private ?PublishHouse $publishHouse = null;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Book
     */
    public function getBook(): Book
    {
        return $this->book;
    }

    public function addBook(Book $book): static
    {
        if (!$this->book->contains($book)) {
            $this->book->add($book);
            $book->setPublishHouseBook($this);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        if ($this->book->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getPublishHouseBook() === $this) {
                $book->setPublishHouseBook(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PublishHouse>
     */
    public function getPublishHouse(): Collection
    {
        return $this->publishHouse;
    }

    public function addPublishHouse(PublishHouse $publishHouse): static
    {
        if (!$this->publishHouse->contains($publishHouse)) {
            $this->publishHouse->add($publishHouse);
            $publishHouse->setPublishHouseBook($this);
        }

        return $this;
    }

    public function removePublishHouse(PublishHouse $publishHouse): static
    {
        if ($this->publishHouse->removeElement($publishHouse)) {
            // set the owning side to null (unless already changed)
            if ($publishHouse->getPublishHouseBook() === $this) {
                $publishHouse->setPublishHouseBook(null);
            }
        }

        return $this;
    }

    public function setBook(?Book $book): static
    {
        $this->book = $book;

        return $this;
    }

    public function setPublishHouse(?PublishHouse $publishHouse): static
    {
        $this->publishHouse = $publishHouse;

        return $this;
    }
}
