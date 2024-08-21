<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    private ?Cinema $cinema = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\Column(length: 5)]
    private ?string $ageRate = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $cast = null;

    #[ORM\Column(length: 30)]
    private ?string $director = null;

    /**
     * @var Collection<int, LoanPeriod>
     */
    #[ORM\OneToMany(targetEntity: LoanPeriod::class, mappedBy: 'movie')]
    private Collection $loanPeriods;

    /**
     * @var Collection<int, MovieLanguage>
     */
    #[ORM\OneToMany(targetEntity: MovieLanguage::class, mappedBy: 'movie')]
    private Collection $movieLanguages;

    /**
     * @var Collection<int, Session>
     */
    #[ORM\OneToMany(targetEntity: Session::class, mappedBy: 'movie')]
    private Collection $sessions;

    public function __construct()
    {
        $this->loanPeriods = new ArrayCollection();
        $this->movieLanguages = new ArrayCollection();
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getAgeRate(): ?string
    {
        return $this->ageRate;
    }

    public function setAgeRate(string $ageRate): static
    {
        $this->ageRate = $ageRate;

        return $this;
    }

    public function getCast(): ?string
    {
        return $this->cast;
    }

    public function setCast(string $cast): static
    {
        $this->cast = $cast;

        return $this;
    }

    public function getDirector(): ?string
    {
        return $this->director;
    }

    public function setDirector(string $director): static
    {
        $this->director = $director;

        return $this;
    }

    /**
     * @return Collection<int, LoanPeriod>
     */
    public function getLoanPeriods(): Collection
    {
        return $this->loanPeriods;
    }

    public function addLoanPeriod(LoanPeriod $loanPeriod): static
    {
        if (!$this->loanPeriods->contains($loanPeriod)) {
            $this->loanPeriods->add($loanPeriod);
            $loanPeriod->setMovie($this);
        }

        return $this;
    }

    public function removeLoanPeriod(LoanPeriod $loanPeriod): static
    {
        if ($this->loanPeriods->removeElement($loanPeriod)) {
            // set the owning side to null (unless already changed)
            if ($loanPeriod->getMovie() === $this) {
                $loanPeriod->setMovie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MovieLanguage>
     */
    public function getMovieLanguages(): Collection
    {
        return $this->movieLanguages;
    }

    public function addMovieLanguage(MovieLanguage $movieLanguage): static
    {
        if (!$this->movieLanguages->contains($movieLanguage)) {
            $this->movieLanguages->add($movieLanguage);
            $movieLanguage->setMovie($this);
        }

        return $this;
    }

    public function removeMovieLanguage(MovieLanguage $movieLanguage): static
    {
        if ($this->movieLanguages->removeElement($movieLanguage)) {
            // set the owning side to null (unless already changed)
            if ($movieLanguage->getMovie() === $this) {
                $movieLanguage->setMovie(null);
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
            $session->setMovie($this);
        }

        return $this;
    }

    public function removeSession(Session $session): static
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getMovie() === $this) {
                $session->setMovie(null);
            }
        }

        return $this;
    }
}
