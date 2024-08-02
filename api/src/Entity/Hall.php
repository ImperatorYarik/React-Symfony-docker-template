<?php

namespace App\Entity;

use App\Repository\HallRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HallRepository::class)]
class Hall
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'halls')]
    private ?Cinema $cinema = null;

    #[ORM\Column]
    private ?int $number = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    /**
     * @var Collection<int, HallRow>
     */
    #[ORM\OneToMany(targetEntity: HallRow::class, mappedBy: 'hall')]
    private Collection $hallRows;

    /**
     * @var Collection<int, Session>
     */
    #[ORM\OneToMany(targetEntity: Session::class, mappedBy: 'hall')]
    private Collection $sessions;

    public function __construct()
    {
        $this->hallRows = new ArrayCollection();
        $this->sessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCinema(): ?Cinema
    {
        return $this->cinema;
    }

    public function setCinema(?Cinema $cinema): static
    {
        $this->cinema = $cinema;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection<int, HallRow>
     */
    public function getHallRows(): Collection
    {
        return $this->hallRows;
    }

    public function addHallRow(HallRow $hallRow): static
    {
        if (!$this->hallRows->contains($hallRow)) {
            $this->hallRows->add($hallRow);
            $hallRow->setHall($this);
        }

        return $this;
    }

    public function removeHallRow(HallRow $hallRow): static
    {
        if ($this->hallRows->removeElement($hallRow)) {
            // set the owning side to null (unless already changed)
            if ($hallRow->getHall() === $this) {
                $hallRow->setHall(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): static
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions->add($session);
            $session->setHall($this);
        }

        return $this;
    }

    public function removeSession(Session $session): static
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getHall() === $this) {
                $session->setHall(null);
            }
        }

        return $this;
    }
}
