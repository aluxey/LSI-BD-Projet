<?php

namespace App\Tests\Repository;

use App\Entity\Evenement;
use App\Entity\ForumEvenement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ForumEvenementTest extends KernelTestCase
{
  private EntityManagerInterface $entityManager;

  protected function setUp(): void
  {
    self::bootKernel();
    $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);

    $conn = $this->entityManager->getConnection();
    $platform = $conn->getDatabasePlatform();

    // Désactiver les contraintes de clé étrangère pour le test
    $conn->executeStatement('SET FOREIGN_KEY_CHECKS=0');

    // Vider les tables
    $conn->executeStatement($platform->getTruncateTableSQL('forum_evenement', true));
    $conn->executeStatement($platform->getTruncateTableSQL('evenement', true));

    // Réactiver les contraintes de clé étrangère
    $conn->executeStatement('SET FOREIGN_KEY_CHECKS=1');
  }

  /**
   * @test
   */
  public function testFindByNom(): void
  {
    $evenement = new Evenement();
    $evenement->setNom('Test Event');
    $evenement->setDateEvent(new \DateTime());
    $evenement->setDescription('Description de test');

    $forum = new ForumEvenement();
    $forum->setTitre('Forum Test');
    $forum->setEvenement($evenement);
    $evenement->setForumEvenement($forum);

    $this->entityManager->persist($evenement);
    $this->entityManager->persist($forum);
    $this->entityManager->flush();

    $repository = $this->entityManager->getRepository(Evenement::class);
    $result = $repository->findOneBy(['nom' => 'Test Event']);

    $this->assertNotNull($result);
    $this->assertEquals('Test Event', $result->getNom());
  }

  public function testFindByTitre(): void
  {
    $forum = new ForumEvenement();
    $forum->setTitre('Forum Test');

    $evenement = new Evenement();
    $evenement->setNom('Test Event');
    $evenement->setDateEvent(new \DateTime());

    // Lien obligatoire
    $forum->setEvenement($evenement);
    $evenement->setForumEvenement($forum);

    $this->entityManager->persist($evenement);
    $this->entityManager->persist($forum);
    $this->entityManager->flush();

    $repository = $this->entityManager->getRepository(ForumEvenement::class);
    $result = $repository->findOneBy(['titre' => 'Forum Test']);

    $this->assertNotNull($result);
    $this->assertEquals('Forum Test', $result->getTitre());
    $this->assertEquals('Test Event', $result->getEvenement()->getNom());
  }
}
