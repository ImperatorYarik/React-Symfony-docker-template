<?php

namespace App\Entity;

use App\Repository\HallRowRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HallRowRepository::class)]
class HallRow
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'hallRows')]
    private ?Hall $hall = null;

    #[ORM\Column]
    private ?int $number = null;

    #[ORM\ManyToOne(inversedBy: 'hallRow')]
    private ?HallRowCategory $hallRowCategory = null;

    /**
     * @var Collection<int, HallSeat>
     */
    #[ORM\OneToMany(targetEntity: HallSeat::class, mappedBy: 'hallRow')]
    private Collection $hallSeats;

    public function __construct()
    {
        $this->hallSeats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHall(): ?Hall
    {
        return $this->hall;
    }

    public function setHall(?Hall $hall): static
    {
        $this->hall = $hall;

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

    public function getHallRowCategory(): ?HallRowCategory
    {
        return $this->hallRowCategory;
    }

    public function setHallRowCategory(?HallRowCategory $hallRowCategory): static
    {
        $this->hallRowCategory = $hallRowCategory;

        return $this;
    }

    /**
     * @return Collection<int, HallSeat>
     */
    public function getHallSeats(): Collection
    {
        return $this->hallSeats;
    }

    public function addHallSeat(HallSeat $hallSeat): static
    {
        if (!$this->hallSeats->contains($hallSeat)) {
            $this->hallSeats->add($hallSeat);
            $hallSeat->setHallRow($this);
        }

        return $this;
    }

    public function removeHallSeat(HallSeat $hallSeat): static
    {
        if ($this->hallSeats->removeElement($hallSeat)) {
            // set the owning side to null (unless already changed)
            if ($hallSeat->getHallRow() === $this) {
                $hallSeat->setHallRow(null);
            }
        }

        return $this;
    }
}
