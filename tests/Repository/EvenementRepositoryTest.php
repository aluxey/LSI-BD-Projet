<?php

namespace App\Tests\Repository;

use App\Entity\Evenement;
use App\Entity\ForumEvenement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EvenementRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);

        $conn = $this->entityManager->getConnection();
        $platform = $conn->getDatabasePlatform();
 
        $conn->executeStatement('SET FOREIGN_KEY_CHECKS=0');

        $conn->executeStatement($platform->getTruncateTableSQL('forum_evenement', true));
        $conn->executeStatement($platform->getTruncateTableSQL('evenement', true));

        $conn->executeStatement('SET FOREIGN_KEY_CHECKS=1');

        // Création des objets de test
        $evenement = new Evenement();
        $evenement->setNom("Test Event");
        $evenement->setDateEvent(new \DateTime());
        $evenement->setDescription("Description de test");

        $forum = new ForumEvenement();
        $forum->setTitre("Forum Test");
        $forum->setEvenement($evenement);
        $evenement->setForumEvenement($forum);

        $this->entityManager->persist($forum);
        $this->entityManager->persist($evenement);
        $this->entityManager->flush();
    }


    public function testFindByNameField(): void
    {
        $repo = $this->entityManager->getRepository(Evenement::class);
        $result = $repo->findBy(['nom' => 'Test Event']);
        $this->assertNotEmpty($result);
        $this->assertEquals('Test Event', $result[0]->getNom());
    }

    public function testFindByInvalidName(): void
    {
        $repo = $this->entityManager->getRepository(Evenement::class);
        $result = $repo->findBy(['nom' => 'Invalid Name']);
        $this->assertEmpty($result);
    }

    public function testInsertAndRetrieveEvenement(): void
    {
        $evenement = new Evenement();
        $evenement->setNom("Hackathon 2025");
        $evenement->setDateEvent(new \DateTime('2025-10-10'));
        $evenement->setDescription("48-hour hackathon");

        $forum = new ForumEvenement();
        $forum->setTitre("Hack Forum");
        $forum->setEvenement($evenement);
        $evenement->setForumEvenement($forum);

        $this->entityManager->persist($forum);
        $this->entityManager->persist($evenement);
        $this->entityManager->flush();

        $repo = $this->entityManager->getRepository(Evenement::class);
        $result = $repo->findOneBy(['nom' => 'Hackathon 2025']);
        $this->assertNotNull($result);
        $this->assertEquals("Hackathon 2025", $result->getNom());
    }
}
