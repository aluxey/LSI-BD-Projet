<?php

namespace App\Tests\Repository;

use App\Entity\Projet;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProjetRepositoryTest extends KernelTestCase
{
    private $entityManager;
    private $repository;

    protected function setUp(): void
    {
        // Démarre le kernel de Symfony pour obtenir l'EntityManager
        self::bootKernel();
        $this->entityManager = self::$container->get('doctrine.orm.entity_manager');
        $this->repository = $this->entityManager->getRepository(Projet::class);
    }

    public function testFindByNameField()
    {
        // Setup: Ajouter un projet pour le test
        $projet = new Projet();
        $projet->setNom('Test Projet');
        $projet->setDescription('Test Description');
        $projet->setDateEvent(new \DateTime());
        $this->entityManager->persist($projet);
        $this->entityManager->flush();

        // Action: Appeler la méthode
        $result = $this->repository->findByNameField('Test Projet');

        // Assert: Vérifier que le projet est retourné
        $this->assertCount(1, $result);
        $this->assertEquals('Test Projet', $result[0]->getNom());
    }

    public function testFindOneByIdField()
    {
        // Setup: Ajouter un projet pour le test
        $projet = new Projet();
        $projet->setNom('Projet 1');
        $projet->setDescription('Description 1');
        $projet->setDateEvent(new \DateTime());
        $this->entityManager->persist($projet);
        $this->entityManager->flush();

        // Action: Appeler la méthode
        $result = $this->repository->findOneByIdField($projet->getId());

        // Assert: Vérifier que le projet est trouvé
        $this->assertNotNull($result);
        $this->assertEquals($projet->getNom(), $result->getNom());
    }

    public function testCreateProjet()
    {
        // Action: Créer un projet
        $projetId = $this->repository->createProjet('New Projet', 'Description du projet', new \DateTime());

        // Assert: Vérifier que le projet est bien créé
        $projet = $this->repository->findOneByIdField($projetId);
        $this->assertNotNull($projet);
        $this->assertEquals('New Projet', $projet->getNom());
    }

    public function testDeleteProjet()
    {
        // Setup: Ajouter un projet pour le test
        $projet = new Projet();
        $projet->setNom('Projet à Supprimer');
        $projet->setDescription('Description à supprimer');
        $projet->setDateEvent(new \DateTime());
        $this->entityManager->persist($projet);
        $this->entityManager->flush();

        // Action: Supprimer le projet
        $rowsAffected = $this->repository->deleteProjet($projet->getId());

        // Assert: Vérifier que le projet est supprimé
        $this->assertEquals(1, $rowsAffected);
        $this->assertNull($this->repository->findOneByIdField($projet->getId()));
    }
}
