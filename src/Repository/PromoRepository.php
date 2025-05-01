<?php

namespace App\Repository;

use App\Entity\Promo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Promo>
 */
class PromoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Promo::class);
    }

    /**
     * @return Promo[] Returns an array of Promo objects
     */
    public function findByNameField($name): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT id, nom FROM promo WHERE nom = :nom";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['nom' => $name]);

        $results = $resultSet->fetchAllAssociative();

        $promos = [];

        foreach ($results as $row) {
            // Création de l'objet Promo
            $promo = new Promo();
            $promo->setId($row['id']);
            $promo->setNom($row['nom']);
            $promos[] = $promo;
        }
        
        return $promos;
    }

    /**
     * @return Promo|null Returns an Promo object or null
     */
    public function findOneByIdField($id): ?Promo
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT id, nom FROM promo WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);

        $result = $resultSet->fetchAssociative();

        // Création de l'objet Promo
        $promo = new Promo();
        $promo->setId($result['id']);
        $promo->setNom($result['nom']);
        
        return $promo;
    }

    /**
     * @return int Returns the id of the Promo created
     */
    public function createPromo($nom, $description, $date_event): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "INSERT INTO promo (nom) VALUES (:nom)";

        $stmt = $conn->prepare($sql);
        $stmt->executeStatement(['nom' => $name]);

        return $conn->lastInsertId();
    }

    /**
     * @return int Returns the number of Promo updated
     */
    public function updatePromo($id, $nom): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "UPDATE promo SET nom = :nom WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $rowsAffected = $stmt->executeStatement(['id' => $id, 'nom' => $name]);

        return $rowsAffected;
    }

    /**
     * @return int Returns the number of Promo deleted
     */
    public function deleteEvenement($id): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "DELETE promo WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $rowsAffected = $stmt->executeStatement(['id' => $id]);

        return $rowsAffected;
    }
}
