<?php

namespace App\Repository;

use App\Entity\ForumEvenement;
use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ForumEvenement>
 */
class ForumEvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ForumEvenement::class);
    }

    /**
     * @return ForumEvenement Returns the Evenement objects
     */
    public function findByEvenementIdField($id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT fe.id as fe_id, e.titre as fe_titre
                FROM forum_evenement as fe
                JOIN evenement as e ON forum_evenement.evenement_id = evenement.id
                WHERE e.id = :id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);

        // $results = $resultSet->fetchAllAssociative();
        $result = $resultSet->fetchAssociative();

        // Création de l'objet Evenement
        $evenement = new ForumEvenement();
        $evenement->setId($result['fe_id']);
        $evenement->setTitre($result['fe_titre']);
        
        return $evenement;
    }

    /**
     * @return ForumEvenement[] Returns an array of Evenement objects
     */
    public function findByEvenementNameField($id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT fe.id as fe_id, e.titre as fe_titre, e.id as e_id
                FROM forum_evenement as fe
                JOIN evenement as e ON forum_evenement.evenement_id = evenement.id
                WHERE e.id = :id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);

        $results = $resultSet->fetchAllAssociative();
        // $result = $resultSet->fetchAssociative();
        

        $forumEvenements = [];

        foreach ($results as $row) {
            // Création de l'objet Evenement
            $forumEvenement = new ForumEvenement();
            $forumEvenement->setId($row['fe_id']);
            $forumEvenement->setTitre($row['fe_titre']);
            $evenement = new Evenement();
            $evenement->setId($row['e_id']);
            $forumEvenement->setEvenement($evenement);
            $forumEvenements[] = $forumEvenement;
        }
        
        return $forumEvenements;
    }

    /**
     * @return int Returns the id of the Evenement created
     */
    public function createForumEvenement($titre, $event_id): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "INSERT INTO forum_evenement (titre, evenement_id) VALUES (:titre, :event_id)";

        $stmt = $conn->prepare($sql);
        $stmt->executeStatement([
            'titre' => $titre,
            'event_id' => $event_id
        ]);

        return $conn->lastInsertId();
    }

    /**
     * @return int Returns the number of Evenement updated
     */
    public function updateForumEvenement($id, $titre): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "UPDATE forum_evenement SET titre = :titret WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $rowsAffected = $stmt->executeStatement([
            'id' => $id,
            'titre' => $titre
        ]);

        return $rowsAffected;
    }

    /**
     * @return int Returns the number of Evenement deleted
     */
    public function deleteForumEvenement($id): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "DELETE forum_evenement WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $rowsAffected = $stmt->executeStatement(['id' => $id]);

        return $rowsAffected;
    }
}
