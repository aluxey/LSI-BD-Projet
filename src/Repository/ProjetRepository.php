<?php

namespace App\Repository;

use App\Entity\Projet;
use App\Entity\Membre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Projet>
 */
class ProjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projet::class);
    }

    /**
     * @return Projet[] Returns an array of Projet objects
     */
    public function findByNameField($name): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT p.id as p_id, p.nom as p_nom, p.description as p_desc, p.date_event as p_date
                FROM projet as p
                WHERE nom = :nom";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['nom' => $name]);

        $results = $resultSet->fetchAllAssociative();

        $projets = [];

        foreach ($results as $row) {
            // Création de l'objet Projet
            $projet = new Projet();
            $projet->setId($row['p_id']);
            $projet->setNom($row['p_nom']);
            $projet->setDescription($row['p_desc']);
            $projet->setDateEvent($row['p_date']);
            $projets[] = $projet;
        }
        
        return $projets;
    }

    /**
     * @return Projet|null Returns an Projet object or null
     */
    public function findOneByIdField($id): ?Projet
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT p.id as p_id, p.nom as p_nom, p.description as p_desc, p.date_event as p_date
                FROM projet as p
                WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);

        // $results = $resultSet->fetchAllAssociative();
        $result = $resultSet->fetchAssociative();

        // Création de l'objet Projet
        $projet = new Projet();
        $projet->setId($result['p_id']);
        $projet->setNom($result['p_nom']);
        $projet->setDescription($result['p_desc']);
        $projet->setDateEvent($result['p_date']);
        
        return $projet;
    }

    /**
     * @return Membre[] Returns an array of Projet objects
     */
    public function findMembresByIdField($id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT m.id as m_id, m.nom as m_nom, m.prenom as m_prenom, m.email as m_mail, m.password as m_mdp, m.role as m_role,
                        p.id as p_id, p.nom as p_nom
                FROM membre_projet as mp
                JOIN membre as m ON mp.membre_id = m.id
                JOIN projet as p ON mp.projet_id = p.id
                WHERE p_id = :id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);

        $results = $resultSet->fetchAllAssociative();

        $membres = [];

        foreach ($results as $row) {
            // Création de l'objet Membre
            $membre = new Membre();
            $membre->setId($row['m_id']);
            $membre->setNom($row['m_nom']);
            $membre->setNom($row['m_prenom']);
            $membre->setNom($row['m_mail']);
            $membre->setNom($row['m_mdp']);
            $membre->setNom($row['m_role']);
            $promo = new Promo();
            $promo->setId($row['p_id']);
            $promo->setNom($row['p_nom']);
            $membre->setPromo($promo);
            $membres[] = $membre;
        }
        
        return $membres;
    }

    /**
     * @return int Returns the id of the Projet created
     */
    public function createProjet($nom, $description, $date_event): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "INSERT INTO projet (nom, description, date_event) VALUES (:nom, :description, :date_event)";

        $stmt = $conn->prepare($sql);
        $stmt->executeStatement([
            'nom' => $name,
            'description' => $description,
            'date_event' => $date_event
        ]);

        return $conn->lastInsertId();
    }

    /**
     * @return int Returns the number of Projet updated
     */
    public function updateProjet($id, $nom, $description, $date_event): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "UPDATE projet SET nom = :nom, description = :description, date_event = :date_event WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $rowsAffected = $stmt->executeStatement([
            'id' => $id,
            'nom' => $name,
            'description' => $description,
            'date_event' => $date_event
        ]);

        return $rowsAffected;
    }

    /**
     * @return Projet Returns the number of Projet deleted
     */
    public function deleteProjet($id): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "DELETE projet WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $rowsAffected = $stmt->executeStatement(['id' => $id]);

        return $rowsAffected;
    }

    /**
     * @return int Returns the id of the Projet created
     */
    public function addMembre($idProjet, $idMembre): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "INSERT INTO membre_projet (projet_id, membre_id) VALUES (:projet_id, :membre_id)";

        $stmt = $conn->prepare($sql);
        $stmt->executeStatement([
            'projet_id' => $idProjet,
            'membre_id' => $idMembre
        ]);

        return $conn->lastInsertId();
    }

    /**
     * @return Projet Returns the number of Projet deleted
     */
    public function removeMembre($idProjet, $idMembre): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "DELETE membre_projet WHERE projet_id = :projet_id AND membre_id = :membre_id";

        $stmt = $conn->prepare($sql);
        $rowsAffected = 
        $stmt->executeStatement([
            'projet_id' => $idProjet,
            'membre_id' => $idMembre
        ]);

        return $rowsAffected;
    }
}
