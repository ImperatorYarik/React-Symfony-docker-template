<?php

namespace App\Entity;

use App\Repository\GlobalCinemaSettingsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GlobalCinemaSettingsRepository::class)]
class GlobalCinemaSettings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $phoneNumber = null;

    /**
     * @var Collection<int, Cinema>
     */
    #[ORM\OneToMany(targetEntity: Cinema::class, mappedBy: 'GlobalCinemaSettingsId')]
    private Collection $cinemas;

    public function __construct()
    {
        $this->cinemas = new ArrayCollection();
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

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Collection<int, Cinema>
     */
    public function getCinemas(): Collection
    {
        return $this->cinemas;
    }

    public function addCinema(Cinema $cinema): static
    {
        if (!$this->cinemas->contains($cinema)) {
            $this->cinemas->add($cinema);
            $cinema->setGlobalCinemaSettingsId($this);
        }

        return $this;
    }

    public function removeCinema(Cinema $cinema): static
    {
        if ($this->cinemas->removeElement($cinema)) {
            // set the owning side to null (unless already changed)
            if ($cinema->getGlobalCinemaSettingsId() === $this) {
                $cinema->setGlobalCinemaSettingsId(null);
            }
        }

        return $this;
    }

}
