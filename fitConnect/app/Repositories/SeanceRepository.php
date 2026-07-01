<?php

namespace App\Repositories;

use App\Entities\Seance;
use Config\Database;
use PDO;

class SeanceRepository
{
    private PDO $db;
    
    public function __construct()
    {
        $this->db = Database::getConnection();
    }
    
    public function findAll(): array
    {
        $stmt = $this->db->query('
            SELECT s.*, 
                   a.nom as adherent_nom, a.prenom as adherent_prenom,
                   sal.nom_salle,
                   ta.libelle as activite_libelle,
                   e.nom_equipement
            FROM seance s
            LEFT JOIN ADHERENT a ON s.id_adherent = a.id_adherent
            LEFT JOIN SALLE sal ON s.id_salle = sal.id_salle
            LEFT JOIN TYPE_ACTIVITE ta ON s.id_activite = ta.id_activite
            LEFT JOIN EQUIPEMENT e ON s.id_equipement = e.id_equipement
            ORDER BY s.date_seance DESC
        ');
        
        $seances = [];
        while ($row = $stmt->fetch()) {
            $seance = new Seance(
                $row['date_seance'],
                $row['duree'],
                $row['id_adherent'],
                $row['id_salle'],
                $row['id_activite'],
                $row['id_equipement'],
                $row['id_seance']
            );
            $seances[] = $seance;
        }
        
        return $seances;
    }
    
    public function findById(int $id): ?Seance
    {
        $stmt = $this->db->prepare('
            SELECT s.*, 
                   a.nom as adherent_nom, a.prenom as adherent_prenom,
                   sal.nom_salle,
                   ta.libelle as activite_libelle,
                   e.nom_equipement
            FROM SEANCE s
            LEFT JOIN ADHERENT a ON s.id_adherent = a.id_adherent
            LEFT JOIN SALLE sal ON s.id_salle = sal.id_salle
            LEFT JOIN TYPE_ACTIVITE ta ON s.id_activite = ta.id_activite
            LEFT JOIN EQUIPEMENT e ON s.id_equipement = e.id_equipement
            WHERE s.id_seance = :id
        ');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        
        if (!$row) {
            return null;
        }
        
        return new Seance(
            $row['date_seance'],
            $row['duree'],
            $row['id_adherent'],
            $row['id_salle'],
            $row['id_activite'],
            $row['id_equipement'],
            $row['id_seance']
        );
    }
    
    public function findByAdherent(int $idAdherent): array
    {
        $stmt = $this->db->prepare('
            SELECT s.*, 
                   a.nom as adherent_nom, a.prenom as adherent_prenom,
                   sal.nom_salle,
                   ta.libelle as activite_libelle,
                   e.nom_equipement
            FROM SEANCE s
            LEFT JOIN ADHERENT a ON s.id_adherent = a.id_adherent
            LEFT JOIN SALLE sal ON s.id_salle = sal.id_salle
            LEFT JOIN TYPE_ACTIVITE ta ON s.id_activite = ta.id_activite
            LEFT JOIN EQUIPEMENT e ON s.id_equipement = e.id_equipement
            WHERE s.id_adherent = :idAdherent
            ORDER BY s.date_seance DESC
        ');
        $stmt->execute(['idAdherent' => $idAdherent]);
        
        $seances = [];
        while ($row = $stmt->fetch()) {
            $seance = new Seance(
                $row['date_seance'],
                $row['duree'],
                $row['id_adherent'],
                $row['id_salle'],
                $row['id_activite'],
                $row['id_equipement'],
                $row['id_seance']
            );
            $seances[] = $seance;
        }
        
        return $seances;
    }
    
    public function findBySalle(int $idSalle): array
    {
        $stmt = $this->db->prepare('
            SELECT s.*, 
                   a.nom as adherent_nom, a.prenom as adherent_prenom,
                   sal.nom_salle,
                   ta.libelle as activite_libelle,
                   e.nom_equipement
            FROM SEANCE s
            LEFT JOIN ADHERENT a ON s.id_adherent = a.id_adherent
            LEFT JOIN SALLE sal ON s.id_salle = sal.id_salle
            LEFT JOIN TYPE_ACTIVITE ta ON s.id_activite = ta.id_activite
            LEFT JOIN EQUIPEMENT e ON s.id_equipement = e.id_equipement
            WHERE s.id_salle = :idSalle
            ORDER BY s.date_seance DESC
        ');
        $stmt->execute(['idSalle' => $idSalle]);
        
        $seances = [];
        while ($row = $stmt->fetch()) {
            $seance = new Seance(
                $row['date_seance'],
                $row['duree'],
                $row['id_adherent'],
                $row['id_salle'],
                $row['id_activite'],
                $row['id_equipement'],
                $row['id_seance']
            );
            $seances[] = $seance;
        }
        
        return $seances;
    }
    
    public function create(Seance $seance): int
    {
        $stmt = $this->db->prepare('
            INSERT INTO SEANCE (date_seance, duree, id_adherent, id_salle, id_activite, id_equipement)
            VALUES (:date_seance, :duree, :id_adherent, :id_salle, :id_activite, :id_equipement)
        ');
        
        $stmt->execute([
            'date_seance' => $seance->getDateSeance(),
            'duree' => $seance->getDuree(),
            'id_adherent' => $seance->getIdAdherent(),
            'id_salle' => $seance->getIdSalle(),
            'id_activite' => $seance->getIdActivite(),
            'id_equipement' => $seance->getIdEquipement()
        ]);
        
        return (int) $this->db->lastInsertId();
    }
    
    public function update(Seance $seance): bool
    {
        $stmt = $this->db->prepare('
            UPDATE SEANCE 
            SET date_seance = :date_seance, 
                duree = :duree, 
                id_adherent = :id_adherent, 
                id_salle = :id_salle, 
                id_activite = :id_activite, 
                id_equipement = :id_equipement
            WHERE id_seance = :id
        ');
        
        return $stmt->execute([
            'date_seance' => $seance->getDateSeance(),
            'duree' => $seance->getDuree(),
            'id_adherent' => $seance->getIdAdherent(),
            'id_salle' => $seance->getIdSalle(),
            'id_activite' => $seance->getIdActivite(),
            'id_equipement' => $seance->getIdEquipement(),
            'id' => $seance->getIdSeance()
        ]);
    }
    
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM SEANCE WHERE id_seance = :id');
        return $stmt->execute(['id' => $id]);
    }
}
