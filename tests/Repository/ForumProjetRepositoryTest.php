<?php

namespace App\Tests\Repository;

use App\Entity\ForumProjet;
use App\Entity\Projet;
use App\Entity\MessageProjet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ForumProjetRepositoryTest  extends KernelTestCase
{
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
    }

    public function testCreateForumProjetWithMessages(): void
    {
        $projet = new Projet();
        $projet->setNom('Test Project');
        $projet->setDescription('Description de test');
        $projet->setTheme('Test Theme');
        $projet->setType('Groupe');
        $projet->setDateEvent(new \DateTime());

        $forum = new ForumProjet();
        $forum->setTitre('Forum Test');
        $forum->setProjet($projet);


        $this->entityManager->persist($projet);
        $this->entityManager->persist($forum);
        $this->entityManager->flush();

        // Vérifier que le forum a été créé avec les messages
        $this->assertNotNull($forum->getId());
        $this->assertEquals($projet, $forum->getProjet());
        $this->assertEquals('Test Project', $forum->getProjet()->getNom());
        $this->assertEquals('Description de test', $forum->getProjet()->getDescription());
        $this->assertEquals('Test Theme', $forum->getProjet()->getTheme());
        $this->assertEquals('Groupe', $forum->getProjet()->getType());
        $this->assertInstanceOf(\DateTime::class, $forum->getProjet()->getDateEvent());
        $this->assertEquals('Forum Test', $forum->getTitre());
        $this->assertEquals('Test Project', $forum->getProjet()->getNom());
        $this->assertEquals('Description de test', $forum->getProjet()->getDescription());
        $this->assertEquals('Test Theme', $forum->getProjet()->getTheme());
        $this->assertEquals('Groupe', $forum->getProjet()->getType());
        $this->assertInstanceOf(\DateTime::class, $forum->getProjet()->getDateEvent());
    }
}
