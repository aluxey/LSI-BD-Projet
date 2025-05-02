<?php

namespace App\Repository;

use App\Entity\MessageProjet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MessageProjet>
 */
class MessageProjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessageProjet::class);
    }

    /**
     * @return MessageProjet|null Returns an MessageProjet object or null
     */
    public function findOneByIdField($id): ?MessageProjet
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT mp.message as mp_message, mp.date_message as mp_date_message, m.id as m_id, m.nom as m_nom, m.prenom as m_prenom
                FROM message_projet as mp
                JOIN membre as m ON mp.membre_id = m.id
                WHERE mp.id = :id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);

        // $results = $resultSet->fetchAllAssociative();
        $result = $resultSet->fetchAssociative();

        // Création de l'objet MessageProjet
        $message = new MessageProjet();
        $message->setId($result['mp_id']);
        $message->setNom($result['mp_date_message']);
        $membre = new Membre();
        $membre->setId($result['m_id']);
        $membre->setNom($result['m_nom']);
        $membre->setPrenom($result['m_prenom']);
        $message->setMembre($membre);
        
        return $message;
    }

    /**
     * @return MessageProjet[] Returns an array of MessageProjet objects
     */
    public function findMessagesByForumProjetIdField($id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT mp.message as mp_message, mp.date_message as mp_date_message, m.id as m_id, m.nom as m_nom, m.prenom as m_prenom
                FROM message_projet as mp
                JOIN membre as m ON mp.membre_id = m.id
                WHERE mp.forum_projet_id = :id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);

        $results = $resultSet->fetchAllAssociative();

        $messages = [];

        foreach ($results as $row) {
            // Création de l'objet MessageProjet
            $message = new MessageProjet();
            $message->setId($row['mp_id']);
            $message->setNom($row['mp_date_message']);
            $membre = new Membre();
            $membre->setId($row['m_id']);
            $membre->setNom($row['m_nom']);
            $membre->setPrenom($row['m_prenom']);
            $message->setMembre($membre);
            $messages[] = $message;
        }
        
        return $messages;
    }

    /**
     * @return int Returns the id of the MessageProjet created
     */
    public function createMessageProjet($idForumProjet, $idMembre, $message, $dateMessage): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "INSERT INTO message_projet (forum_projet_id, membre_id, message, date_message) VALUES (:forum_projet_id, :membre_id, :message, :date_message)";

        $stmt = $conn->prepare($sql);
        $stmt->executeStatement([
            'forum_projet_id' => $idForumProjet,
            'membre_id' => $idMembre,
            'message' => $message,
            'date_message' => $dateMessage
        ]);

        return $conn->lastInsertId();
    }

    /**
     * @return int Returns the number of MessageProjet updated
     */
    public function updateMessageProjet($id, $message, $dateMessage): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "UPDATE message_projet SET message = :message, date_message = :date_message WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $rowsAffected = $stmt->executeStatement([
            'id' => $id,
            'message' => $message,
            'date_message' => $dateMessage
        ]);

        return $rowsAffected;
    }

    /**
     * @return int Returns the number of MessageProjet deleted
     */
    public function deleteMessageProjet($id): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "DELETE FROM message_projet WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $rowsAffected = $stmt->executeStatement(['id' => $id]);

        return $rowsAffected;
    }
}
