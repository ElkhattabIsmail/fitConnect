<?php

namespace App\Repositories;

use App\Entities\Adherent;
use Config\Database;
use PDO;

class AdherentRepository
{
    private PDO $db;
    
    public function __construct()
    {
        $this->db = Database::getConnection();
    }
    
    public function findAll(): array
    {
        $stmt = $this->db->query('
            SELECT a.*, s.nom_salle 
            FROM ADHERENT a 
            LEFT JOIN SALLE s ON a.id_salle = s.id_salle 
            ORDER BY a.nom, a.prenom
        ');
        
        $adherents = [];
        while ($row = $stmt->fetch()) {
            $adherent = new Adherent(
                $row['nom'],
                $row['prenom'],
                $row['email'],
                $row['date_inscription'],
                $row['id_salle'],
                $row['telephone'],
                $row['id_adherent']
            );
            $adherents[] = $adherent;
        }
        
        return $adherents;
    }
    
    public function findById(int $id): ?Adherent
    {
        $stmt = $this->db->prepare('
            SELECT a.*, s.nom_salle 
            FROM ADHERENT a 
            LEFT JOIN SALLE s ON a.id_salle = s.id_salle 
            WHERE a.id_adherent = :id
        ');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        
        if (!$row) {
            return null;
        }
        
        return new Adherent(
            $row['nom'],
            $row['prenom'],
            $row['email'],
            $row['date_inscription'],
            $row['id_salle'],
            $row['telephone'],
            $row['id_adherent']
        );
    }
    
    public function findBySalle(int $idSalle): array
    {
        $stmt = $this->db->prepare('
            SELECT a.*, s.nom_salle 
            FROM ADHERENT a 
            LEFT JOIN SALLE s ON a.id_salle = s.id_salle 
            WHERE a.id_salle = :idSalle 
            ORDER BY a.nom, a.prenom
        ');
        $stmt->execute(['idSalle' => $idSalle]);
        
        $adherents = [];
        while ($row = $stmt->fetch()) {
            $adherent = new Adherent(
                $row['nom'],
                $row['prenom'],
                $row['email'],
                $row['date_inscription'],
                $row['id_salle'],
                $row['telephone'],
                $row['id_adherent']
            );
            $adherents[] = $adherent;
        }
        
        return $adherents;
    }
    
    public function create(Adherent $adherent): int
    {
        $stmt = $this->db->prepare('
            INSERT INTO ADHERENT (nom, prenom, email, telephone, date_inscription, id_salle)
            VALUES (:nom, :prenom, :email, :telephone, :date_inscription, :id_salle)
        ');
        
        $stmt->execute([
            'nom' => $adherent->getNom(),
            'prenom' => $adherent->getPrenom(),
            'email' => $adherent->getEmail(),
            'telephone' => $adherent->getTelephone(),
            'date_inscription' => $adherent->getDateInscription(),
            'id_salle' => $adherent->getIdSalle()
        ]);
        
        return (int) $this->db->lastInsertId();
    }
    
    public function update(Adherent $adherent): bool
    {
        $stmt = $this->db->prepare('
            UPDATE ADHERENT 
            SET nom = :nom, 
                prenom = :prenom, 
                email = :email, 
                telephone = :telephone, 
                id_salle = :id_salle
            WHERE id_adherent = :id
        ');
        
        return $stmt->execute([
            'nom' => $adherent->getNom(),
            'prenom' => $adherent->getPrenom(),
            'email' => $adherent->getEmail(),
            'telephone' => $adherent->getTelephone(),
            'id_salle' => $adherent->getIdSalle(),
            'id' => $adherent->getIdAdherent()
        ]);
    }
    
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM ADHERENT WHERE id_adherent = :id');
        return $stmt->execute(['id' => $id]);
    }
    
    public function hasSeances(int $idAdherent): bool
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM SEANCE WHERE id_adherent = :id');
        $stmt->execute(['id' => $idAdherent]);
        return $stmt->fetchColumn() > 0;
    }
    
    public function hasActiveAbonnement(int $idAdherent): bool
    {
        $stmt = $this->db->prepare('
            SELECT COUNT(*) 
            FROM ABONNEMENT 
            WHERE id_adherent = :id 
            AND date_fin >= CURDATE()
        ');
        $stmt->execute(['id' => $idAdherent]);
        return $stmt->fetchColumn() > 0;
    }
}
