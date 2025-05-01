<?php

namespace App\Tests\Repository;

use App\Entity\ForumProjet;
use App\Entity\Projet;
use App\Repository\ForumProjetRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManagerInterface;

class ForumProjetRepositoryTest extends KernelTestCase
{
    private $entityManager;
    private $repository;

    protected function setUp(): void
    {
        // Démarre le kernel de Symfony pour obtenir l'EntityManager
        self::bootKernel();
        $this->entityManager = self::$container->get(EntityManagerInterface::class);
        $this->repository = $this->entityManager->getRepository(ForumProjet::class);
    }

    public function testFindByProjetIdField(): void
    {
        // Crée un projet et un forum_projet en base de données
        $projet = new Projet();
        $projet->setNom('Projet 2025');
        $projet->setDescription('A great project for 2025.');
        $this->entityManager->persist($projet);
        
        $forumProjet = new ForumProjet();
        $forumProjet->setTitre('Project Forum');
        $forumProjet->setProjet($projet);
        $this->entityManager->persist($forumProjet);
        $this->entityManager->flush();

        // Exécute la méthode que tu veux tester
        $result = $this->repository->findByProjetIdField($projet->getId());

        // Vérifie que l'objet ForumProjet trouvé correspond à l'attendu
        $this->assertEquals('Project Forum', $result[0]->getTitre());
        $this->assertEquals($projet->getId(), $result[0]->getProjet()->getId());
    }

    public function testFindByProjetNameField(): void
    {
        // Crée un projet et un forum_projet en base de données
        $projet = new Projet();
        $projet->setNom('Workshop 2025');
        $projet->setDescription('An interactive workshop on web technologies.');
        $this->entityManager->persist($projet);

        $forumProjet = new ForumProjet();
        $forumProjet->setTitre('WebDev Project Forum');
        $forumProjet->setProjet($projet);
        $this->entityManager->persist($forumProjet);
        $this->entityManager->flush();

        // Exécute la méthode que tu veux tester
        $result = $this->repository->findByProjetNameField($projet->getId());

        // Vérifie que la taille du tableau est correcte
        $this->assertCount(1, $result);
        $this->assertEquals('WebDev Project Forum', $result[0]->getTitre());
    }

    public function testCreateForumProjet(): void
    {
        // Crée un projet
        $projet = new Projet();
        $projet->setNom('Hackathon 2025');
        $projet->setDescription('A 48-hour hackathon event.');
        $this->entityManager->persist($projet);
        $this->entityManager->flush();

        // Crée un forum_projet
        $forumProjetId = $this->repository->createForumProjet('Hackathon Project Forum', $projet->getId());

        // Vérifie que l'ID du forum_projet créé est valide
        $this->assertGreaterThan(0, $forumProjetId);
    }

    public function testUpdateForumProjet(): void
    {
        // Crée un projet et un forum_projet en base de données
        $projet = new Projet();
        $projet->setNom('Old Project');
        $projet->setDescription('This project will be updated.');
        $this->entityManager->persist($projet);

        $forumProjet = new ForumProjet();
        $forumProjet->setTitre('Old Project Forum');
        $forumProjet->setProjet($projet);
        $this->entityManager->persist($forumProjet);
        $this->entityManager->flush();

        // Mise à jour du forum_projet
        $updatedRows = $this->repository->updateForumProjet($forumProjet->getId(), 'Updated Project Forum');

        // Vérifie que la mise à jour a bien affecté une ligne
        $this->assertGreaterThan(0, $updatedRows);

        // Recherche à nouveau et vérifie la mise à jour
        $updatedForumProjet = $this->repository->find($forumProjet->getId());
        $this->assertEquals('Updated Project Forum', $updatedForumProjet->getTitre());
    }

    public function testDeleteForumProjet(): void
    {
        // Crée un projet et un forum_projet en base de données
        $projet = new Projet();
        $projet->setNom('Project to Delete');
        $projet->setDescription('This project will be deleted.');
        $projet->setDateProjet(new \DateTime('2025-03-01'));
        $this->entityManager->persist($projet);

        $forumProjet = new ForumProjet();
        $forumProjet->setTitre('Project Forum');
        $forumProjet->setProjet($projet);
        $this->entityManager->persist($forumProjet);
        $this->entityManager->flush();

        // Supprime le forum_projet
        $deletedRows = $this->repository->deleteForumProjet($forumProjet->getId());

        // Vérifie que la suppression a affecté une ligne
        $this->assertGreaterThan(0, $deletedRows);
    }

    protected function tearDown(): void
    {
        // Ferme le manager après chaque test pour ne pas laisser de connexions ouvertes
        parent::tearDown();
    }
}
