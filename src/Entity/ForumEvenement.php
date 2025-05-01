<?php

namespace App\Entity;

use App\Repository\ForumEvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ForumEvenementRepository::class)]
class ForumEvenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titre = null;

    #[ORM\OneToOne(inversedBy: 'forumEvenement', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Evenement $evenement = null;

    #[ORM\OneToMany(mappedBy: 'forumEvenement', targetEntity: MessageEvenement::class, cascade: ['persist', 'remove'])]
    private Collection $messagesEvenement;


    public function __construct()
    {
        $this->messagesEvenement = new ArrayCollection();
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

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(Evenement $evenement): static
    {
        $this->evenement = $evenement;

        return $this;
    }

    public function getMessagesEvenement(): Collection
    {
        return $this->messagesEvenement;
    }

    public function addMessagesEvenement(MessageEvenement $message): self
    {
        if (!$this->messagesEvenement->contains($message)) {
            $this->messagesEvenement[] = $message;
            $message->setForumEvenement($this);
        }

        return $this;
    }

    public function removeMessagesEvenement(MessageEvenement $message): self
    {
        if ($this->messagesEvenement->removeElement($message)) {
            if ($message->getForumEvenement() === $this) {
                $message->setForumEvenement(null);
            }
        }

        return $this;
    }
}
