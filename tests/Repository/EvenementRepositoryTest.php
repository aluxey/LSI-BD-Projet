<?php

namespace App\Tests\Repository;

use App\Entity\Evenement;
use App\Entity\ForumEvenement;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManagerInterface;

class EvenementRepositoryTest extends KernelTestCase
{
    private $entityManager;
    private $repository;

    protected function setUp(): void
    {
        // Démarre le kernel de Symfony pour obtenir l'EntityManager
        self::bootKernel();
        $this->entityManager = self::$container->get(EntityManagerInterface::class);
        $this->repository = $this->entityManager->getRepository(Evenement::class);
    }

    public function testFindByNameField(): void
    {
        // Crée un événement en base de données
        $evenement = new Evenement();
        $evenement->setNom('Conference 2025');
        $evenement->setDescription('A great conference for tech enthusiasts.');
        $evenement->setDateEvent(new \DateTime('2025-05-01'));
        
        $forumEvenement = new ForumEvenement();
        $forumEvenement->setTitre('Tech Forum');
        $evenement->setForumEvenement($forumEvenement);

        $this->entityManager->persist($evenement);
        $this->entityManager->flush();

        // Exécute la méthode que tu veux tester
        $result = $this->repository->findByNameField('Conference 2025');

        // Vérifie que le résultat correspond à l'attendu
        $this->assertCount(1, $result);
        $this->assertEquals('Conference 2025', $result[0]->getNom());
    }

    public function testFindOneByIdField(): void
    {
        // Crée un événement en base de données
        $evenement = new Evenement();
        $evenement->setNom('Workshop 2025');
        $evenement->setDescription('An interactive workshop on modern web technologies.');
        $evenement->setDateEvent(new \DateTime('2025-06-01'));
        
        $forumEvenement = new ForumEvenement();
        $forumEvenement->setTitre('WebDev Forum');
        $evenement->setForumEvenement($forumEvenement);

        $this->entityManager->persist($evenement);
        $this->entityManager->flush();

        // Recherche l'événement par son ID
        $result = $this->repository->findOneByIdField($evenement->getId());

        // Vérifie que l'événement trouvé est celui qu'on vient d'ajouter
        $this->assertNotNull($result);
        $this->assertEquals($evenement->getId(), $result->getId());
        $this->assertEquals('Workshop 2025', $result->getNom());
    }

    public function testCreateEvenement(): void
    {
        // Crée un événement
        $result = $this->repository->createEvenement('Hackathon 2025', 'A 48-hour hackathon event.', new \DateTime('2025-07-15'));

        // Vérifie que l'ID de l'événement nouvellement créé est valide (non nul)
        $this->assertGreaterThan(0, $result);
    }

    public function testUpdateEvenement(): void
    {
        // Crée un événement en base de données
        $evenement = new Evenement();
        $evenement->setNom('Old Event');
        $evenement->setDescription('This event will be updated.');
        $evenement->setDateEvent(new \DateTime('2025-01-01'));
        
        $forumEvenement = new ForumEvenement();
        $forumEvenement->setTitre('Old Forum');
        $evenement->setForumEvenement($forumEvenement);

        $this->entityManager->persist($evenement);
        $this->entityManager->flush();

        // Mise à jour des informations de l'événement
        $updatedRows = $this->repository->updateEvenement($evenement->getId(), 'Updated Event', 'This event was updated.', new \DateTime('2025-02-01'));

        // Vérifie que la mise à jour a réussi (le nombre de lignes affectées doit être > 0)
        $this->assertGreaterThan(0, $updatedRows);

        // Recherche à nouveau l'événement et vérifie les changements
        $updatedEvenement = $this->repository->findOneByIdField($evenement->getId());
        $this->assertEquals('Updated Event', $updatedEvenement->getNom());
    }

    public function testDeleteEvenement(): void
    {
        // Crée un événement en base de données
        $evenement = new Evenement();
        $evenement->setNom('Event to Delete');
        $evenement->setDescription('This event will be deleted.');
        $evenement->setDateEvent(new \DateTime('2025-03-01'));
        
        $forumEvenement = new ForumEvenement();
        $forumEvenement->setTitre('Event Forum');
        $evenement->setForumEvenement($forumEvenement);

        $this->entityManager->persist($evenement);
        $this->entityManager->flush();

        // Supprime l'événement
        $deletedRows = $this->repository->deleteEvenement($evenement->getId());

        // Vérifie que l'événement a bien été supprimé
        $this->assertGreaterThan(0, $deletedRows);
    }

    protected function tearDown(): void
    {
        // Ferme le manager après chaque test pour ne pas laisser de connexions ouvertes
        parent::tearDown();
    }
}
