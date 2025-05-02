<?php

namespace App\Repository;

use App\Entity\Membre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Promo;

/**
 * @extends ServiceEntityRepository<Membre>
 */
class MembreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Membre::class);
    }

    /**
 * @return Membre[] Returns an array of Membre objects
 */
public function findAll(): array
{
    $conn = $this->getEntityManager()->getConnection();

    $sql = "SELECT m.id as m_id, m.nom as m_nom, m.prenom as m_prenom, m.email as m_email
            FROM membre as m";

    $stmt = $conn->prepare($sql);
    $resultSet = $stmt->executeQuery();

    $results = $resultSet->fetchAllAssociative();

    $membres = [];

    foreach ($results as $row) {
        // Création de l'objet Membre
        $membre = new Membre();
        $membre->setId($row['m_id']);
        $membre->setNom($row['m_nom']);
        $membre->setPrenom($row['m_prenom']);
        $membre->setEmail($row['m_email']);
        $membres[] = $membre;
    }
    
    return $membres;
}

    /**
     * @return Membre[] Returns an array of Membre objects
     */
    public function findByNameFieldWithPromo($name): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT m.id as m_id, m.nom as m_nom, m.prenom as m_prenom, m.email as m_email, m.password as m_password, m.role as m_role,
                        p.id as p_id, p.nom as p_nom
                FROM membre as m
                LEFT JOIN promo as p on m.promo_id = p.id
                WHERE m.nom = :nom";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['nom' => $name]);

        $results = $resultSet->fetchAllAssociative();

        $membres = [];

        foreach ($results as $row) {
            // Création de l'objet Membre
            $membre = new Membre();
            $membre->setId($row['m_id']);
            $membre->setNom($row['m_nom']);
            $membre->setPrenom($row['m_prenom']);
            $membre->setEmail($row['m_email']);
            $membre->setPassword($row['m_password']);
            $membre->setRole($row['m_role']);
            $promo = new Promo();
            $promo->setId($row['p_id']);
            $promo->setNom($row['p_nom']);
            $membre->setPromo($promo);
            $membres[] = $membre;
        }
        
        return $membres;
    }

        /**
     * @return Membre[] Returns an array of Membre objects
     */
    public function findByNameField($name): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT m.id as m_id, m.nom as m_nom, m.prenom as m_prenom, m.email as m_email
                FROM membre as m
                WHERE nom = :nom";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['nom' => $name]);

        $results = $resultSet->fetchAllAssociative();

        $membres = [];

        foreach ($results as $row) {
            // Création de l'objet Membre
            $membre = new Membre();
            $membre->setId($row['m_id']);
            $membre->setNom($row['m_nom']);
            $membre->setPrenom($row['m_prenom']);
            $membre->setEmail($row['m_email']);
            $membres[] = $membre;
        }
        
        return $membres;
    }

    /**
     * @return Membre|null Returns an Membre object or null
     */
    public function findOneByIdField($id): ?Membre
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT m.id as m_id, m.nom as m_nom, m.prenom as m_prenom, m.email as m_email, m.password as m_password, m.role as m_role,
                        p.id as p_id, p.nom as p_nom
                FROM membre as m
                JOIN promo as p on m.promo_id = p.id
                WHERE m.id = :id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);

        // $results = $resultSet->fetchAllAssociative();
        $result = $resultSet->fetchAssociative();
        
        $membre = new Membre();
        $membre->setId($result['m_id']);
        $membre->setNom($result['m_nom']);
        $membre->setPrenom($result['m_prenom']);
        $membre->setEmail($result['m_email']);
        $membre->setPassword($result['m_password']);
        $membre->setRole($result['m_role']);
        $promo = new Promo();
        $promo->setId($result['p_id']);
        $promo->setNom($result['p_nom']);
        $membre->setPromo($promo);
        
        return $membre;
    }

    /**
     * @return int Returns the id of the Membre created
     */
    public function createMembre($nom, $prenom, $email, $password, $role): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "INSERT INTO membre (nom, prenom, email, password, role) VALUES (:nom, :prenom, :email, :password, :role)";

        $stmt = $conn->prepare($sql);
        $stmt->executeStatement([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'password' => $password,
            'role' => $role
        ]);

        return $conn->lastInsertId();
    }

    /**
     * @return int Returns the number of Membre updated
     */
    public function updateMembre($id, $nom, $prenom, $email, $password, $role): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "UPDATE membre SET nom = :nom, prenom = :prenom, email = :email, password = :password, role = :role WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $rowsAffected = $stmt->executeStatement([
            'id' => $id,
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'password' => $password,
            'role' => $role
        ]);

        return $rowsAffected;
    }

    /**
     * @return Membre Returns the number of Membre deleted
     */
    public function deleteMembre($id): int
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "DELETE membre WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $rowsAffected = $stmt->executeStatement(['id' => $id]);

        return $rowsAffected;
    }
}
