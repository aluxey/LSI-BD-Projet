<?php

namespace App\Tests\Repository;

use App\Entity\ForumEvenement;
use App\Entity\Evenement;
use App\Repository\ForumEvenementRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManagerInterface;

class ForumEvenementRepositoryTest extends KernelTestCase
{
    private $entityManager;
    private $repository;

    protected function setUp(): void
    {
        // Démarre le kernel de Symfony pour obtenir l'EntityManager
        self::bootKernel();
        $this->entityManager = self::$container->get(EntityManagerInterface::class);
        $this->repository = $this->entityManager->getRepository(ForumEvenement::class);
    }

    public function testFindByEvenementIdField(): void
    {
        // Crée un événement et un forum_evenement en base de données
        $evenement = new Evenement();
        $evenement->setNom('Conference 2025');
        $evenement->setDescription('A great conference for tech enthusiasts.');
        $evenement->setDateEvent(new \DateTime('2025-05-01'));
        $this->entityManager->persist($evenement);
        
        $forumEvenement = new ForumEvenement();
        $forumEvenement->setTitre('Tech Forum');
        $forumEvenement->setEvenement($evenement);
        $this->entityManager->persist($forumEvenement);
        $this->entityManager->flush();

        // Exécute la méthode que tu veux tester
        $result = $this->repository->findByEvenementIdField($evenement->getId());

        // Vérifie que l'objet ForumEvenement trouvé correspond à l'attendu
        $this->assertEquals('Tech Forum', $result->getTitre());
        $this->assertEquals($evenement->getId(), $result->getEvenement()->getId());
    }

    public function testFindByEvenementNameField(): void
    {
        // Crée un événement et un forum_evenement en base de données
        $evenement = new Evenement();
        $evenement->setNom('Workshop 2025');
        $evenement->setDescription('An interactive workshop on modern web technologies.');
        $evenement->setDateEvent(new \DateTime('2025-06-01'));
        $this->entityManager->persist($evenement);

        $forumEvenement = new ForumEvenement();
        $forumEvenement->setTitre('WebDev Forum');
        $forumEvenement->setEvenement($evenement);
        $this->entityManager->persist($forumEvenement);
        $this->entityManager->flush();

        // Exécute la méthode que tu veux tester
        $result = $this->repository->findByEvenementNameField($evenement->getId());

        // Vérifie que la taille du tableau est correcte
        $this->assertCount(1, $result);
        $this->assertEquals('WebDev Forum', $result[0]->getTitre());
    }

    public function testCreateForumEvenement(): void
    {
        // Crée un événement
        $evenement = new Evenement();
        $evenement->setNom('Hackathon 2025');
        $evenement->setDescription('A 48-hour hackathon event.');
        $evenement->setDateEvent(new \DateTime('2025-07-15'));
        $this->entityManager->persist($evenement);
        $this->entityManager->flush();

        // Crée un forum_evenement
        $forumEvenementId = $this->repository->createForumEvenement('Hackathon Forum', $evenement->getId());

        // Vérifie que l'ID de l'événement créé est valide
        $this->assertGreaterThan(0, $forumEvenementId);
    }

    public function testUpdateForumEvenement(): void
    {
        // Crée un événement et un forum_evenement en base de données
        $evenement = new Evenement();
        $evenement->setNom('Old Event');
        $evenement->setDescription('This event will be updated.');
        $evenement->setDateEvent(new \DateTime('2025-01-01'));
        $this->entityManager->persist($evenement);

        $forumEvenement = new ForumEvenement();
        $forumEvenement->setTitre('Old Forum');
        $forumEvenement->setEvenement($evenement);
        $this->entityManager->persist($forumEvenement);
        $this->entityManager->flush();

        // Mise à jour du forum_evenement
        $updatedRows = $this->repository->updateForumEvenement($forumEvenement->getId(), 'Updated Forum');

        // Vérifie que la mise à jour a bien affecté une ligne
        $this->assertGreaterThan(0, $updatedRows);

        // Recherche à nouveau et vérifie la mise à jour
        $updatedForumEvenement = $this->repository->find($forumEvenement->getId());
        $this->assertEquals('Updated Forum', $updatedForumEvenement->getTitre());
    }

    public function testDeleteForumEvenement(): void
    {
        // Crée un événement et un forum_evenement en base de données
        $evenement = new Evenement();
        $evenement->setNom('Event to Delete');
        $evenement->setDescription('This event will be deleted.');
        $evenement->setDateEvent(new \DateTime('2025-03-01'));
        $this->entityManager->persist($evenement);

        $forumEvenement = new ForumEvenement();
        $forumEvenement->setTitre('Event Forum');
        $forumEvenement->setEvenement($evenement);
        $this->entityManager->persist($forumEvenement);
        $this->entityManager->flush();

        // Supprime le forum_evenement
        $deletedRows = $this->repository->deleteForumEvenement($forumEvenement->getId());

        // Vérifie que la suppression a affecté une ligne
        $this->assertGreaterThan(0, $deletedRows);
    }

    protected function tearDown(): void
    {
        // Ferme le manager après chaque test pour ne pas laisser de connexions ouvertes
        parent::tearDown();
    }
}
