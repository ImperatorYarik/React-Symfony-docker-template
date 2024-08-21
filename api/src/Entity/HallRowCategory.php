<?php

namespace App\Entity;

use App\Repository\HallRowCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HallRowCategoryRepository::class)]
class HallRowCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $priceCoef = null;

    /**
     * @var Collection<int, HallRow>
     */
    #[ORM\OneToMany(targetEntity: HallRow::class, mappedBy: 'hallRowCategory')]
    private Collection $hallRow;

    public function __construct()
    {
        $this->hallRow = new ArrayCollection();
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

    public function getPriceCoef(): ?string
    {
        return $this->priceCoef;
    }

    public function setPriceCoef(string $priceCoef): static
    {
        $this->priceCoef = $priceCoef;

        return $this;
    }

    /**
     * @return Collection<int, HallRow>
     */
    public function getHallRow(): Collection
    {
        return $this->hallRow;
    }

    public function addHallRow(HallRow $hallRow): static
    {
        if (!$this->hallRow->contains($hallRow)) {
            $this->hallRow->add($hallRow);
            $hallRow->setHallRowCategory($this);
        }

        return $this;
    }

    public function removeHallRow(HallRow $hallRow): static
    {
        if ($this->hallRow->removeElement($hallRow)) {
            // set the owning side to null (unless already changed)
            if ($hallRow->getHallRowCategory() === $this) {
                $hallRow->setHallRowCategory(null);
            }
        }

        return $this;
    }

}
