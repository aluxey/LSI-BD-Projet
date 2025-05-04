<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $theme = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateEvent = null;

    #[ORM\ManyToMany(targetEntity: Membre::class, mappedBy: 'projets')]
    private Collection $membres;

    #[ORM\OneToMany(mappedBy: 'projet', targetEntity: ForumProjet::class, cascade: ['persist', 'remove'])]
    private Collection $forumProjets;

    public function __construct()
    {
        $this->forumProjets = new ArrayCollection();
        $this->membres = new ArrayCollection();
        if ($this->dateEvent === null) {
            $this->dateEvent = new \DateTime();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

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

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(?string $theme): static
    {
        $this->theme = $theme;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDateEvent(): ?\DateTimeInterface
    {
        return $this->dateEvent;
    }

    public function setDateEvent(\DateTimeInterface $dateEvent): static
    {
        $this->dateEvent = $dateEvent;

        return $this;
    }

    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function setMembres(Collection $membres): static
    {
        $this->membres = $membres;

        return $this;
    }

    public function getForumProjets(): Collection
    {
        return $this->forumProjets;
    }

    public function addForumProjet(ForumProjet $forumProjet): self
    {
        if (!$this->forumProjets->contains($forumProjet)) {
            $this->forumProjets[] = $forumProjet;
            $forumProjet->setProjet($this);
        }

        return $this;
    }

    public function removeForumProjet(ForumProjet $forumProjet): self
    {
        if ($this->forumProjets->removeElement($forumProjet)) {
            if ($forumProjet->getProjet() === $this) {
                $forumProjet->setProjet(null);
            }
        }

        return $this;
    }
    
    public function __toString(): string
    {
        return $this->nom ?? 'Projet sans nom';
    }
}
