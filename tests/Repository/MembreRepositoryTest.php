<?php

namespace App\Tests\Repository;

use App\Entity\Membre;
use App\Repository\MembreRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManagerInterface;

class MembreRepositoryTest extends KernelTestCase
{
    private $entityManager;
    private $repository;

    protected function setUp(): void
    {
        // Démarre le kernel de Symfony pour obtenir l'EntityManager
        self::bootKernel();
        $this->entityManager = self::$container->get(EntityManagerInterface::class);
        $this->repository = $this->entityManager->getRepository(Membre::class);
    }

    public function testFindByNameField(): void
    {
        // Crée un membre en base de données
        $membre = new Membre();
        $membre->setNom('Test');
        $membre->setPrenom('User');
        $membre->setMail('testuser@example.com');
        $membre->setMdp('password');
        $membre->setRole('ROLE_USER');
        $this->entityManager->persist($membre);
        $this->entityManager->flush();

        // Exécute la méthode que tu veux tester
        $result = $this->repository->findByNameField('Test');

        // Vérifie que le résultat correspond à l'attendu
        $this->assertCount(1, $result);
        $this->assertEquals('Test', $result[0]->getNom());
        $this->assertEquals('User', $result[0]->getPrenom());
    }

    public function testFindOneByIdField(): void
    {
        // Crée un membre en base de données
        $membre = new Membre();
        $membre->setNom('John');
        $membre->setPrenom('Doe');
        $membre->setMail('johndoe@example.com');
        $membre->setMdp('password123');
        $membre->setRole('ROLE_USER');
        $this->entityManager->persist($membre);
        $this->entityManager->flush();

        // Recherche ce membre par son ID
        $result = $this->repository->findOneByIdField($membre->getId());

        // Vérifie que le membre trouvé est celui qu'on vient d'ajouter
        $this->assertNotNull($result);
        $this->assertEquals($membre->getId(), $result->getId());
        $this->assertEquals('John', $result->getNom());
        $this->assertEquals('Doe', $result->getPrenom());
    }

    public function testCreateMembre(): void
    {
        // Crée un membre et enregistre-le
        $result = $this->repository->createMembre('Alice', 'Smith', 'alice.smith@example.com', 'password456', 'ROLE_USER');

        // Vérifie que l'ID du membre nouvellement créé est valide (non nul)
        $this->assertGreaterThan(0, $result);
    }

    public function testUpdateMembre(): void
    {
        // Crée un membre en base de données
        $membre = new Membre();
        $membre->setNom('Tom');
        $membre->setPrenom('Jerry');
        $membre->setMail('tom.jerry@example.com');
        $membre->setMdp('secret');
        $membre->setRole('ROLE_USER');
        $this->entityManager->persist($membre);
        $this->entityManager->flush();

        // Mise à jour des informations du membre
        $updatedRows = $this->repository->updateMembre($membre->getId(), 'Tommy', 'Jerry', 'tommy.jerry@example.com', 'newpassword', 'ROLE_ADMIN');

        // Vérifie que la mise à jour a réussi (le nombre de lignes affectées doit être > 0)
        $this->assertGreaterThan(0, $updatedRows);

        // Recherche à nouveau le membre et vérifie les changements
        $updatedMembre = $this->repository->findOneByIdField($membre->getId());
        $this->assertEquals('Tommy', $updatedMembre->getNom());
        $this->assertEquals('ROLE_ADMIN', $updatedMembre->getRole());
    }

    public function testDeleteMembre(): void
    {
        // Crée un membre en base de données
        $membre = new Membre();
        $membre->setNom('Delete');
        $membre->setPrenom('Me');
        $membre->setMail('delete.me@example.com');
        $membre->setMdp('deletepassword');
        $membre->setRole('ROLE_USER');
        $this->entityManager->persist($membre);
        $this->entityManager->flush();

        // Supprime le membre
        $deletedRows = $this->repository->deleteMembre($membre->getId());

        // Vérifie que le membre a bien été supprimé
        $this->assertGreaterThan(0, $deletedRows);
    }

    protected function tearDown(): void
    {
        // Ferme le manager après chaque test pour ne pas laisser de connexions ouvertes
        parent::tearDown();
    }
}
