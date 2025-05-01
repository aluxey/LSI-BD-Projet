<?php

namespace App\Tests\Repository;

use App\Entity\MessageEvenement;
use App\Entity\Membre;
use App\Repository\MessageEvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MessageEvenementRepositoryTest extends KernelTestCase
{
    private $entityManager;
    private $repository;

    protected function setUp(): void
    {
        // Démarre le kernel de Symfony pour obtenir l'EntityManager
        self::bootKernel();
        $this->entityManager = self::$container->get(EntityManagerInterface::class);
        $this->repository = $this->entityManager->getRepository(MessageEvenement::class);
    }

    public function testFindOneByIdField(): void
    {
        // Crée un membre et un message en base de données
        $membre = new Membre();
        $membre->setNom('Dupont');
        $membre->setPrenom('Pierre');
        $this->entityManager->persist($membre);
        $this->entityManager->flush();

        $message = new MessageEvenement();
        $message->setMessage('Test message');
        $message->setDateMessage(new \DateTime());
        $message->setMembre($membre);
        $this->entityManager->persist($message);
        $this->entityManager->flush();

        // Recherche du message par ID
        $result = $this->repository->findOneByIdField($message->getId());

        // Vérifie que les données du message sont correctes
        $this->assertEquals('Test message', $result->getMessage());
        $this->assertEquals($membre->getNom(), $result->getMembre()->getNom());
    }

    public function testFindMessagesByForumEvenementIdField(): void
    {
        // Crée un membre et des messages pour un forum evenement
        $membre = new Membre();
        $membre->setNom('Lemoine');
        $membre->setPrenom('Jean');
        $this->entityManager->persist($membre);
        $this->entityManager->flush();

        $message1 = new MessageEvenement();
        $message1->setMessage('Forum Message 1');
        $message1->setDateMessage(new \DateTime());
        $message1->setMembre($membre);
        $this->entityManager->persist($message1);

        $message2 = new MessageEvenement();
        $message2->setMessage('Forum Message 2');
        $message2->setDateMessage(new \DateTime());
        $message2->setMembre($membre);
        $this->entityManager->persist($message2);

        $this->entityManager->flush();

        // Récupérer les messages pour un forum événement (ici, on suppose qu'il a l'ID 1)
        $messages = $this->repository->findMessagesByForumEvenementIdField(1);

        // Vérifie que les deux messages ont bien été récupérés
        $this->assertCount(2, $messages);
        $this->assertEquals('Forum Message 1', $messages[0]->getMessage());
        $this->assertEquals('Forum Message 2', $messages[1]->getMessage());
    }

    public function testCreateMessageEvenement(): void
    {
        // Crée un membre
        $membre = new Membre();
        $membre->setNom('Robert');
        $membre->setPrenom('François');
        $this->entityManager->persist($membre);
        $this->entityManager->flush();

        // Crée un message
        $forumEvenementId = 1; // Id du forum événement à utiliser
        $messageId = $this->repository->createMessageEvenement($forumEvenementId, $membre->getId(), 'Message de test', new \DateTime());

        // Vérifie que l'ID du message créé est valide
        $this->assertGreaterThan(0, $messageId);
    }

    public function testUpdateMessageEvenement(): void
    {
        // Crée un membre et un message
        $membre = new Membre();
        $membre->setNom('Germain');
        $membre->setPrenom('Luc');
        $this->entityManager->persist($membre);
        $this->entityManager->flush();

        $message = new MessageEvenement();
        $message->setMessage('Ancien message');
        $message->setDateMessage(new \DateTime());
        $message->setMembre($membre);
        $this->entityManager->persist($message);
        $this->entityManager->flush();

        // Mise à jour du message
        $updatedRows = $this->repository->updateMessageEvenement($message->getId(), 'Message mis à jour', new \DateTime());

        // Vérifie que la mise à jour a bien affecté une ligne
        $this->assertGreaterThan(0, $updatedRows);

        // Recherche à nouveau et vérifie la mise à jour
        $updatedMessage = $this->repository->findOneByIdField($message->getId());
        $this->assertEquals('Message mis à jour', $updatedMessage->getMessage());
    }

    public function testDeleteMessageEvenement(): void
    {
        // Crée un membre et un message
        $membre = new Membre();
        $membre->setNom('Leclerc');
        $membre->setPrenom('Pierre');
        $this->entityManager->persist($membre);
        $this->entityManager->flush();

        $message = new MessageEvenement();
        $message->setMessage('Message à supprimer');
        $message->setDateMessage(new \DateTime());
        $message->setMembre($membre);
        $this->entityManager->persist($message);
        $this->entityManager->flush();

        // Supprimer le message
        $deletedRows = $this->repository->deleteMessageEvenement($message->getId());

        // Vérifie que la suppression a affecté une ligne
        $this->assertGreaterThan(0, $deletedRows);
    }

    protected function tearDown(): void
    {
        // Ferme le manager après chaque test pour ne pas laisser de connexions ouvertes
        parent::tearDown();
    }
}
