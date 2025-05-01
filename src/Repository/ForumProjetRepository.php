<?php

namespace App\Repository;

use App\Entity\ForumProjet;
use App\Entity\Projet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ForumProjet>
 */
class ForumProjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ForumProjet::class);
    }

    /**
     * @return ForumProjet Returns the Projet objects
     */
    public function findByProjetIdField($id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT fp.id as fp_id, fp.titre as fp_titre, p.id as p_id
                FROM forum_projet as fp
                JOIN projet as p ON forum_projet.projet_id = projet.id
                WHERE p.id = :id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);

        $results = $resultSet->fetchAllAssociative();
        // $result = $resultSet->fetchAssociative();
        

        $forumProjets = [];

        foreach ($results as $row) {
            // Création de l'objet Projet
            $forumProjet = new ForumProjet();
            $forumProjet->setId($row['fp_id']);
            $forumProjet->setTitre($row['fp_titre']);
            $projet = new Projet();
            $projet->setId($row['p_id']);
            $forumProjet->setProjet($projet);
            $forumProjets[] = $forumProjet;
        }
        
        return $forumProjets;
    }

    /**
     * @return ForumProjet[] Returns an array of Projet objects
     */
    public function findByProjetNameField($name): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT fp.id as fp_id, fp.titre as fp_titre, p.id as p_id
                FROM forum_projet as fp
                JOIN projet as p ON forum_projet.projet_id = projet.id
                WHERE p.name = :name";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['name' => $name]);

        $results = $resultSet->fetchAllAssociative();
        // $result = $resultSet->fetchAssociative();
        

        $forumProjets = [];

        foreach ($results as $row) {
            // Création de l'objet Projet
            $forumProjet = new ForumProjet();
            $forumProjet->setId($row['fp_id']);
            $forumProjet->setTitre($row['fp_titre']);
            $projet = new Projet();
            $projet->setId($row['p_id']);
            $forumProjet->setProjet($projet);
            $forumProjets[] = $forumProjet;
        }
        
        return $forumProjets;
    }

    /**
     * @return int Returns the id of the Projet created
     */
    public function createForumProjet($titre, $event_id): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "INSERT INTO forum_projet (titre, projet_id) VALUES (:titre, :event_id)";

        $stmt = $conn->prepare($sql);
        $stmt->executeStatement([
            'titre' => $titre,
            'event_id' => $event_id
        ]);

        return $conn->lastInsertId();
    }

    /**
     * @return int Returns the number of Projet updated
     */
    public function updateForumProjet($id, $titre): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "UPDATE forum_projet SET titre = :titret WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $rowsAffected = $stmt->executeStatement([
            'id' => $id,
            'titre' => $titre
        ]);

        return $rowsAffected;
    }

    /**
     * @return int Returns the number of Projet deleted
     */
    public function deleteForumProjet($id): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "DELETE forum_projet WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $rowsAffected = $stmt->executeStatement(['id' => $id]);

        return $rowsAffected;
    }
}
