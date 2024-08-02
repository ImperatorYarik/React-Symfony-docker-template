<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $isSubs = null;

    /**
     * @var Collection<int, MovieLanguage>
     */
    #[ORM\OneToMany(targetEntity: MovieLanguage::class, mappedBy: 'language')]
    private Collection $movieLanguages;

    public function __construct()
    {
        $this->movieLanguages = new ArrayCollection();
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

    public function isSubs(): ?bool
    {
        return $this->isSubs;
    }

    public function setSubs(bool $isSubs): static
    {
        $this->isSubs = $isSubs;

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
            $movieLanguage->setLanguage($this);
        }

        return $this;
    }

    public function removeMovieLanguage(MovieLanguage $movieLanguage): static
    {
        if ($this->movieLanguages->removeElement($movieLanguage)) {
            // set the owning side to null (unless already changed)
            if ($movieLanguage->getLanguage() === $this) {
                $movieLanguage->setLanguage(null);
            }
        }

        return $this;
    }
}
