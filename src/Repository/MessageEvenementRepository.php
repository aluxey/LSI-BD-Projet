<?php

namespace App\Repository;

use App\Entity\MessageEvenement;
use App\Entity\Membre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MessageEvenement>
 */
class MessageEvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessageEvenement::class);
    }

    /**
     * @return MessageEvenement|null Returns an MessageEvenement object or null
     */
    public function findOneByIdField($id): ?MessageEvenement
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT me.message as me_message, me.date_message as me_date_message, m.id as m_id, m.nom as m_nom, m.prenom as m_prenom
                FROM message_evenement as me
                JOIN membre as m ON me.membre_id = m.id
                WHERE me.id = :id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);

        // $results = $resultSet->fetchAllAssociative();
        $result = $resultSet->fetchAssociative();

        // Création de l'objet MessageEvenement
        $message = new MessageEvenement();
        $message->setId($result['me_id']);
        $message->setDateMessage($result['me_date_message']);
        $membre = new Membre();
        $membre->setId($result['m_id']);
        $membre->setNom($result['m_nom']);
        $membre->setPrenom($result['m_prenom']);
        $message->setMembre($membre);
        
        return $message;
    }

    /**
     * @return MessageEvenement[] Returns an array of MessageEvenement objects
     */
    public function findMessagesByForumEvenementIdField($id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT me.id as me_id, me.message as me_message, me.date_message as me_date_message, m.id as m_id, m.nom as m_nom, m.prenom as m_prenom
                FROM message_evenement as me
                JOIN membre as m ON me.membre_id = m.id
                WHERE me.forum_evenement_id = :id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);

        $results = $resultSet->fetchAllAssociative();

        $messages = [];

        foreach ($results as $row) {
            // Création de l'objet MessageEvenement
            $message = new MessageEvenement();
            $message->setId($row['me_id']);
            $message->setMessage($row['me_message']);
            $message->setDateMessage(new \DateTime($row['me_date_message']));
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
     * @return int Returns the id of the MessageEvenement created
     */
    public function createMessageEvenement($idForumEvenement, $idMembre, $message, $dateMessage): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "INSERT INTO message_evenement (forum_evenement_id, membre_id, message, date_message) VALUES (:forum_evenement_id, :membre_id, :message, :date_message)";

        $stmt = $conn->prepare($sql);
        $stmt->executeStatement([
            'forum_evenement_id' => $idForumEvenement,
            'membre_id' => $idMembre,
            'message' => $message,
            'date_message' => $dateMessage
        ]);

        return $conn->lastInsertId();
    }

    /**
     * @return int Returns the number of MessageEvenement updated
     */
    public function updateMessageEvenement($id, $message, $dateMessage): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "UPDATE message_evenement SET message = :message, date_message = :date_message WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $rowsAffected = $stmt->executeStatement([
            'id' => $id,
            'message' => $message,
            'date_message' => $dateMessage
        ]);

        return $rowsAffected;
    }

    /**
     * @return int Returns the number of MessageEvenement deleted
     */
    public function deleteMessageEvenement($id): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "DELETE FROM message_evenement WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $rowsAffected = $stmt->executeStatement(['id' => $id]);

        return $rowsAffected;
    }
}
