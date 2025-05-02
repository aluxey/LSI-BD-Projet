<?php

namespace App\Entity;

use App\Repository\MessageProjetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageProjetRepository::class)]
class MessageProjet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $message = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateMessage = null;

    #[ORM\ManyToOne(targetEntity: ForumProjet::class, inversedBy: 'messagesProjet')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ForumProjet $forumProjet = null;

    #[ORM\ManyToOne(targetEntity: Membre::class, inversedBy: 'messagesProjet')]
    private ?Membre $membre = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getDateMessage(): ?\DateTimeInterface
    {
        return $this->dateMessage;
    }

    public function setDateMessage(?\DateTimeInterface $dateMessage): static
    {
        $this->dateMessage = $dateMessage;

        return $this;
    }

    public function getForumProjet(): ?ForumProjet
    {
        return $this->forumProjet;
    }

    public function setForumProjet(?ForumProjet $forumProjet): self
    {
        $this->forumProjet = $forumProjet;

        return $this;
    }

    public function getMembre(): ?Membre
    {
        return $this->membre;
    }

    public function setMembre(?Membre $membre): self
    {
        $this->membre = $membre;

        return $this;
    }
}
