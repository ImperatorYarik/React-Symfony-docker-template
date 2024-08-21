<?php

namespace App\Entity;

use AllowDynamicProperties;
use App\Repository\CinemaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[AllowDynamicProperties] #[ORM\Entity(repositoryClass: CinemaRepository::class)]
class Cinema
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: 2)]
    private ?string $latitude = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: 2)]
    private ?string $longitude = null;

    #[ORM\ManyToOne(inversedBy: 'cinemas')]
    private ?GlobalCinemaSettings $globalCinemaSettings = null;

    /**
     * @var Collection<int, CinemaShedule>
     */
    #[ORM\OneToMany(targetEntity: CinemaShedule::class, mappedBy: 'cinemaId')]
    private Collection $cinemaSchedules;

    /**
     * @var Collection<int, Hall>
     */
    #[ORM\OneToMany(targetEntity: Hall::class, mappedBy: 'cinemaId')]
    private Collection $halls;

    /**
     * @var Collection<int, Movie>
     */
    #[ORM\OneToMany(targetEntity: Movie::class, mappedBy: 'cinema')]
    private Collection $movies;


    public function __construct()
    {
        $this->cinemaSchedules = new ArrayCollection();
        $this->halls = new ArrayCollection();
        $this->movies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return GlobalCinemaSettings
     */
    public function getGlobalCinemaSettings(): GlobalCinemaSettings
    {
        return $this->globalCinemaSettings;
    }

    public function setGlobalCinemaSettings(?GlobalCinemaSettings $GlobalCinemaSettingsId): static
    {
        $this->GlobalCinemaSettings = $GlobalCinemaSettingsId;

        return $this;
    }

    /**
     * @return Collection<int, CinemaShedule>
     */
    public function getCinemaSchedules(): Collection
    {
        return $this->cinemaSchedules;
    }

    public function addCinemaSchedule(CinemaShedule $cinemaSchedule): static
    {
        if (!$this->cinemaSchedules->contains($cinemaSchedule)) {
            $this->cinemaSchedules->add($cinemaSchedule);
            $cinemaSchedule->setCinema($this);
        }

        return $this;
    }

    public function removeCinemaSchedule(CinemaShedule $cinemaSchedule): static
    {
        if ($this->cinemaSchedules->removeElement($cinemaSchedule)) {
            // set the owning side to null (unless already changed)
            if ($cinemaSchedule->getCinema() === $this) {
                $cinemaSchedule->setCinema(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Hall>
     */
    public function getHalls(): Collection
    {
        return $this->halls;
    }

    public function addHall(Hall $hall): static
    {
        if (!$this->halls->contains($hall)) {
            $this->halls->add($hall);
            $hall->setCinema($this);
        }

        return $this;
    }

    public function removeHall(Hall $hall): static
    {
        if ($this->halls->removeElement($hall)) {
            // set the owning side to null (unless already changed)
            if ($hall->getCinema() === $this) {
                $hall->setCinema(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movie $movie): static
    {
        if (!$this->movies->contains($movie)) {
            $this->movies->add($movie);
            $movie->setCinema($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): static
    {
        if ($this->movies->removeElement($movie)) {
            // set the owning side to null (unless already changed)
            if ($movie->getCinema() === $this) {
                $movie->setCinema(null);
            }
        }

        return $this;
    }

}
