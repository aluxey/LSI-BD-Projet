<?php

namespace App\Entity;

use App\Repository\ForumProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ForumProjetRepository::class)]
class ForumProjet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $titre = null;

    #[ORM\ManyToOne(inversedBy: 'forumProjets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Projet $projet = null;

    #[ORM\OneToMany(mappedBy: 'forumProjet', targetEntity: MessageProjet::class, cascade: ['persist', 'remove'])]
    private Collection $messagesProjet;

    public function __construct()
    {
        $this->messagesProjet = new ArrayCollection();
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

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): self
    {
        $this->projet = $projet;

        if ($projet !== null && !$projet->getForumProjets()->contains($this)) {
            $projet->addForumProjet($this);
        }

        return $this;
    }

    public function getMessages(): Collection
    {
        return $this->messagesProjet;
    }

    public function addMessage(MessageProjet $message): self
    {
        if (!$this->messagesProjet->contains($message)) {
            $this->messagesProjet[] = $message;
            $message->setForumProjet($this);
        }

        return $this;
    }

    public function removeMessage(MessageProjet $message): self
    {
        if ($this->messagesProjet->removeElement($message)) {
            if ($message->getForumProjet() === $this) {
                $message->setForumProjet(null);
            }
        }

        return $this;
    }

}
