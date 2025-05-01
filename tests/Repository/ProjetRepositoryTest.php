<?php

namespace App\Tests\Repository;

use App\Entity\Projet;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManagerInterface;

class ProjetRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
    }

    public function testCreateProjet(): void
    {
        $projet = new Projet();
        $projet->setNom('Projet Test');
        $projet->setDescription('Un test');
        $projet->setTheme('IA');
        $projet->setType('Groupe');
        $projet->setDateEvent(new \DateTime());

        $this->entityManager->persist($projet);
        $this->entityManager->flush();

        $this->assertNotNull($projet->getId());
        $this->assertEquals('Projet Test', $projet->getNom());
    }
}
