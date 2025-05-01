<?php

namespace App\Tests\Repository;

use App\Entity\MessageProjet;
use App\Entity\Membre;
use App\Repository\MessageProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MessageProjetRepositoryTest extends KernelTestCase
{
    private $entityManager;
    private $repository;

    protected function setUp(): void
    {
        // Démarre le kernel de Symfony pour obtenir l'EntityManager
        self::bootKernel();
        $this->entityManager = self::$container->get(EntityManagerInterface::class);
        $this->repository = $this->entityManager->getRepository(MessageProjet::class);
    }

    public function testFindOneByIdField(): void
    {
        // Crée un membre et un message en base de données
        $membre = new Membre();
        $membre->setNom('Durand');
        $membre->setPrenom('Alice');
        $this->entityManager->persist($membre);
        $this->entityManager->flush();

        $message = new MessageProjet();
        $message->setMessage('Test projet message');
        $message->setDateMessage(new \DateTime());
        $message->setMembre($membre);
        $this->entityManager->persist($message);
        $this->entityManager->flush();

        // Recherche du message par ID
        $result = $this->repository->findOneByIdField($message->getId());

        // Vérifie que les données du message sont correctes
        $this->assertEquals('Test projet message', $result->getMessage());
        $this->assertEquals($membre->getNom(), $result->getMembre()->getNom());
    }

    public function testFindMessagesByForumEvenementIdField(): void
    {
        // Crée un membre et des messages pour un forum projet
        $membre = new Membre();
        $membre->setNom('Martin');
        $membre->setPrenom('Paul');
        $this->entityManager->persist($membre);
        $this->entityManager->flush();

        $message1 = new MessageProjet();
        $message1->setMessage('Forum projet Message 1');
        $message1->setDateMessage(new \DateTime());
        $message1->setMembre($membre);
        $this->entityManager->persist($message1);

        $message2 = new MessageProjet();
        $message2->setMessage('Forum projet Message 2');
        $message2->setDateMessage(new \DateTime());
        $message2->setMembre($membre);
        $this->entityManager->persist($message2);

        $this->entityManager->flush();

        // Récupérer les messages pour un forum projet (ici, on suppose qu'il a l'ID 1)
        $messages = $this->repository->findMessagesByForumEvenementIdField(1);

        // Vérifie que les deux messages ont bien été récupérés
        $this->assertCount(2, $messages);
        $this->assertEquals('Forum projet Message 1', $messages[0]->getMessage());
        $this->assertEquals('Forum projet Message 2', $messages[1]->getMessage());
    }

    public function testCreateMessageProjet(): void
    {
        // Crée un membre
        $membre = new Membre();
        $membre->setNom('Petit');
        $membre->setPrenom('Marie');
        $this->entityManager->persist($membre);
        $this->entityManager->flush();

        // Crée un message
        $forumProjetId = 1; // Id du forum projet à utiliser
        $messageId = $this->repository->createMessageProjet($forumProjetId, $membre->getId(), 'Message projet de test', new \DateTime());

        // Vérifie que l'ID du message créé est valide
        $this->assertGreaterThan(0, $messageId);
    }

    public function testUpdateMessageProjet(): void
    {
        // Crée un membre et un message
        $membre = new Membre();
        $membre->setNom('Lemoine');
        $membre->setPrenom('David');
        $this->entityManager->persist($membre);
        $this->entityManager->flush();

        $message = new MessageProjet();
        $message->setMessage('Ancien message projet');
        $message->setDateMessage(new \DateTime());
        $message->setMembre($membre);
        $this->entityManager->persist($message);
        $this->entityManager->flush();

        // Mise à jour du message
        $updatedRows = $this->repository->updateMessageProjet($message->getId(), 'Message projet mis à jour', new \DateTime());

        // Vérifie que la mise à jour a bien affecté une ligne
        $this->assertGreaterThan(0, $updatedRows);

        // Recherche à nouveau et vérifie la mise à jour
        $updatedMessage = $this->repository->findOneByIdField($message->getId());
        $this->assertEquals('Message projet mis à jour', $updatedMessage->getMessage());
    }

    public function testDeleteMessageProjet(): void
    {
        // Crée un membre et un message
        $membre = new Membre();
        $membre->setNom('Robert');
        $membre->setPrenom('Claire');
        $this->entityManager->persist($membre);
        $this->entityManager->flush();

        $message = new MessageProjet();
        $message->setMessage('Message à supprimer projet');
        $message->setDateMessage(new \DateTime());
        $message->setMembre($membre);
        $this->entityManager->persist($message);
        $this->entityManager->flush();

        // Supprimer le message
        $deletedRows = $this->repository->deleteMessageProjet($message->getId());

        // Vérifie que la suppression a affecté une ligne
        $this->assertGreaterThan(0, $deletedRows);
    }

    protected function tearDown(): void
    {
        // Ferme le manager après chaque test pour ne pas laisser de connexions ouvertes
        parent::tearDown();
    }
}
