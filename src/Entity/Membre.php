<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: MembreRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Membre implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $role = null;

    #[ORM\ManyToMany(targetEntity: Projet::class, inversedBy: 'membres')]
    private Collection $projets;

    #[ORM\ManyToOne(targetEntity: Promo::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Promo $promo = null;

    #[ORM\Column(unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private string $password;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: MessageProjet::class)]
    private Collection $messagesProjet;

    #[ORM\OneToMany(mappedBy: 'membre', targetEntity: MessageEvenement::class)]
    private Collection $messagesEvenement;

    public function __construct()
    {
        $this->projets = new ArrayCollection();
        $this->messagesProjet = new ArrayCollection();
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function setRole(?string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getProjets(): Collection
    {
        return $this->projets;
    }

    public function setProjets(Collection $projets): static
    {
        $this->projets = $projets;

        return $this;
    }

    public function getPromo(): ?Promo
    {
        return $this->promo;
    }

    public function setPromo(?Promo $promo): self
    {
        $this->promo = $promo;
        return $this;
    }

    public function addProjet(Projet $projet): self
    {
        if (!$this->projets->contains($projet)) {
            $this->projets[] = $projet;
        }
        return $this;
    }

    public function removeProjet(Projet $projet): self
    {
        $this->projets->removeElement($projet);
        return $this;
    }

    public function getMessagesProjet(): Collection
    {
        return $this->messagesProjet;
    }

    public function addMessageProjet(MessageProjet $message): static
    {
        if (!$this->messagesProjet->contains($message)) {
            $this->messagesProjet[] = $message;
            $message->setMembre($this);
        }

        return $this;
    }


    public function removeMessageProjet(MessageProjet $messageProjet): self
    {
        if ($this->messagesProjet->removeElement($messageProjet)) {
            if ($messageProjet->getMembre() === $this) {
                $messageProjet->setMembre(null);
            }
        }

        return $this;
    }

    public function getMessageEvenements(): Collection
    {
        return $this->messagesEvenement;
    }

    public function addMessageEvenement(MessageEvenement $messageEvenement): self
    {
        if (!$this->messagesEvenement->contains($messageEvenement)) {
            $this->messagesEvenement[] = $messageEvenement;
            $messageEvenement->setMembre($this);
        }

        return $this;
    }

    public function removeMessageEvenement(MessageEvenement $messageEvenement): self
    {
        if ($this->messagesEvenement->removeElement($messageEvenement)) {
            if ($messageEvenement->getMembre() === $this) {
                $messageEvenement->setMembre(null);
            }
        }

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        // Si le mot de passe est déjà haché, on n'effectue pas de hachage
        if (empty($this->password) || !password_verify($password, $this->password)) {
            // Hacher le mot de passe avant de le stocker
            $this->password = password_hash($password, PASSWORD_BCRYPT);
        }

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function getRoles(): array
    {
        return ['ROLE_' . strtoupper($this->role ?? 'USER')];
    }


    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
        // Si des données temporaires liées à l'utilisateur sont stockées, les effacer ici
    }

    public function __toString(): string
    {
        return $this->prenom . ' ' . $this->nom; // Par exemple, afficher le prénom et le nom
    }
}
