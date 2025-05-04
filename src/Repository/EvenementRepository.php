<?php

namespace App\Repository;

use App\Entity\Evenement;
use App\Entity\ForumEvenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Evenement>
 */
class EvenementRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

    /**
     * @return Evenement[] Returns an array of Evenement objects
     */
    public function findAll(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT e.id as e_id, e.nom as e_nom, e.description as e_desc, e.date_event as e_date, fe.id as fe_id, fe.titre as fe_titre
                FROM evenement as e
                LEFT JOIN forum_evenement as fe ON fe.evenement_id = e.id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        $results = $resultSet->fetchAllAssociative();

        $evenements = [];

        foreach ($results as $row) {
            // Création de l'objet Evenement
            $evenement = new Evenement();
            $evenement->setId($row['e_id']);
            $evenement->setNom($row['e_nom']);
            $evenement->setDescription($row['e_desc']);
            $evenement->setDateEvent(new \DateTime($row['e_date']));
            if (!is_null($row['fe_id'])) {
                $forum_evenement = new ForumEvenement();
                $forum_evenement->setId((int)$row['fe_id']);
                $forum_evenement->setTitre($row['fe_titre']);
                $evenement->setForumEvenement($forum_evenement);
            }
            $evenements[] = $evenement;
        }

        return $evenements;
    }

    /**
     * @return Evenement|null Returns an Evenement object or null
     */
    public function findOneByIdField($id): ?Evenement
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT e.id as e_id, e.nom as e_nom, e.description as e_desc, e.date_event as e_date, fe.id as fe_id, fe.titre as fe_titre
                FROM evenement as e
                JOIN forum_evenement as fe ON fe.evenement_id = e.id
                WHERE e.id = :id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);

        // $results = $resultSet->fetchAllAssociative();
        $result = $resultSet->fetchAssociative();

        // Création de l'objet Evenement
        $evenement = new Evenement();
        $evenement->setId($result['e_id']);
        $evenement->setNom($result['e_nom']);
        $evenement->setDescription($result['e_desc']);
        $evenement->setDateEvent(new \DateTime($result['e_date']));
        $forum_evenement = new ForumEvenement();
        $forum_evenement->setId($result['fe_id']);
        $forum_evenement->setTitre($result['fe_titre']);
        $evenement->setForumEvenement($forum_evenement);

        return $evenement;
    }

    /**
     * @return Evenement[] Returns an array of Evenement objects
     */
    public function findByNameField($name): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT e.id as e_id, e.nom as e_nom, e.description as e_desc, e.date_event as e_date, fe.id as fe_id, fe.titre as fe_titre
                FROM evenement as e
                LEFT JOIN forum_evenement as fe ON fe.evenement_id = e.id
                WHERE e.nom = :nom";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['nom' => $name]);

        $results = $resultSet->fetchAllAssociative();

        $evenements = [];

        foreach ($results as $row) {
            // Création de l'objet Evenement
            $evenement = new Evenement();
            $evenement->setId($row['e_id']);
            $evenement->setNom($row['e_nom']);
            $evenement->setDescription($row['e_desc']);
            $evenement->setDateEvent(new \DateTime($row['e_date']));
            $forum_evenement = new ForumEvenement();
            $forum_evenement->setId($row['fe_id']);
            $forum_evenement->setTitre($row['fe_titre']);
            $evenement->setForumEvenement($forum_evenement);
            $evenements[] = $evenement;
        }

        return $evenements;
    }
    
    /**
     * @return int Returns the id of the Evenement created
     */
    public function createEvenement($nom, $description, $date_event): int
    {
        $conn = $this->getEntityManager()->getConnection();

        // 1. Insérer l'événement
        $sqlEvenement = "INSERT INTO evenement (nom, description, date_event) VALUES (:nom, :description, :date_event)";
        $stmt = $conn->prepare($sqlEvenement);
        $stmt->executeStatement([
            'nom' => $nom,
            'description' => $description,
            'date_event' => $date_event
        ]);

        // Récupérer l'ID de l'événement inséré
        $evenementId = $conn->lastInsertId();

        // 2. Créer le forum lié
        $sqlForum = "INSERT INTO forum_evenement (titre, evenement_id) VALUES (:titre, :evenement_id)";
        $stmtForum = $conn->prepare($sqlForum);
        $stmtForum->executeStatement([
            'titre' => 'Forum pour ' . $nom,
            'evenement_id' => $evenementId
        ]);

        return $evenementId;
        // Récupérer l'ID de l'événement inséré
        $evenementId = $conn->lastInsertId();

        // 2. Créer le forum lié
        $sqlForum = "INSERT INTO forum_evenement (titre, evenement_id) VALUES (:titre, :evenement_id)";
        $stmtForum = $conn->prepare($sqlForum);
        $stmtForum->executeStatement([
            'titre' => 'Forum pour ' . $nom,
            'evenement_id' => $evenementId
        ]);

        return $evenementId;
    }

    /**
     * @return int Returns the number of Evenement updated
     */
    public function updateEvenement($id, $nom, $description, $date_event): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "UPDATE evenement SET nom = :nom, description = :description, date_event = :date_event WHERE id = :id";

        $stmt = $conn->prepare($sql);
        return $stmt->executeStatement([
            'id' => $id,
            'nom' => $nom,
            'description' => $description,
            'date_event' => $date_event
        ]);
    }

    /**
     * @return Evenement Returns the number of Evenement deleted
     */
    public function deleteEvenement($id): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "DELETE FROM message_evenement WHERE forum_evenement_id IN (
                SELECT id FROM forum_evenement WHERE evenement_id = :id)";
        $stmt = $conn->prepare($sql);
        $rowsAffected = $stmt->executeStatement(['id' => $id]);

        $sql = "DELETE FROM forum_evenement WHERE evenement_id = :id";
        $stmt = $conn->prepare($sql);
        $rowsAffected = $stmt->executeStatement(['id' => $id]);

        $sql = "DELETE FROM evenement WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $rowsAffected = $stmt->executeStatement(['id' => $id]);

        return $rowsAffected;
    }
}
