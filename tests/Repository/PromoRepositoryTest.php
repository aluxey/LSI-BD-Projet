<?php

namespace App\Tests\Repository;

use App\Entity\Promo;
use App\Repository\PromoRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PromoRepositoryTest extends KernelTestCase
{
    private $entityManager;
    private $repository;

    protected function setUp(): void
    {
        // Démarre le kernel de Symfony pour obtenir l'EntityManager
        self::bootKernel();
        $this->entityManager = self::$container->get('doctrine.orm.entity_manager');
        $this->repository = $this->entityManager->getRepository(Promo::class);
    }

    public function testFindByNameField()
    {
        // Setup: Ajouter une promo pour le test
        $promo = new Promo();
        $promo->setNom('Promo Test');
        $this->entityManager->persist($promo);
        $this->entityManager->flush();

        // Action: Appeler la méthode
        $result = $this->repository->findByNameField('Promo Test');

        // Assert: Vérifier que la promo est retournée
        $this->assertCount(1, $result);
        $this->assertEquals('Promo Test', $result[0]->getNom());
    }

    public function testFindOneByIdField()
    {
        // Setup: Ajouter une promo pour le test
        $promo = new Promo();
        $promo->setNom('Promo 1');
        $this->entityManager->persist($promo);
        $this->entityManager->flush();

        // Action: Appeler la méthode
        $result = $this->repository->findOneByIdField($promo->getId());

        // Assert: Vérifier que la promo est trouvée
        $this->assertNotNull($result);
        $this->assertEquals($promo->getNom(), $result->getNom());
    }

    public function testCreatePromo()
    {
        // Action: Créer une promo
        $promoId = $this->repository->createPromo('New Promo', 'Description de la promo', new \DateTime());

        // Assert: Vérifier que la promo est bien créée
        $promo = $this->repository->findOneByIdField($promoId);
        $this->assertNotNull($promo);
        $this->assertEquals('New Promo', $promo->getNom());
    }

    public function testDeleteEvenement()
    {
        // Setup: Ajouter une promo pour le test
        $promo = new Promo();
        $promo->setNom('Promo à Supprimer');
        $this->entityManager->persist($promo);
        $this->entityManager->flush();

        // Action: Supprimer la promo
        $rowsAffected = $this->repository->deleteEvenement($promo->getId());

        // Assert: Vérifier que la promo est supprimée
        $this->assertEquals(1, $rowsAffected);
        $this->assertNull($this->repository->findOneByIdField($promo->getId()));
    }
}
