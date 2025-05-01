<?php

namespace App\Tests\Repository;

use App\Entity\Promo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PromoRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
    }

    public function testCreatePromo(): void
    {
        $promo = new Promo();
        $promo->setNom('Promo Test');

        $this->entityManager->persist($promo);
        $this->entityManager->flush();

        $repo = $this->entityManager->getRepository(Promo::class);
        $foundPromo = $repo->findOneBy(['nom' => 'Promo Test']);

        $this->assertNotNull($foundPromo);
        $this->assertEquals('Promo Test', $foundPromo->getNom()); 
    }
}
