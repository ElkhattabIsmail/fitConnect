<?php

namespace App\Repositories;

use App\Entities\Abonnement;
use Config\Database;
use PDO;

class AbonnementRepository
{
    private PDO $db;
    
    public function __construct()
    {
        $this->db = Database::getConnection();
    }
    
    public function findAll(): array
    {
        $stmt = $this->db->query('
            SELECT a.*, ad.nom, ad.prenom 
            FROM ABONNEMENT a 
            LEFT JOIN ADHERENT ad ON a.id_adherent = ad.id_adherent 
            ORDER BY a.date_debut DESC
        ');
        
        $abonnements = [];
        while ($row = $stmt->fetch()) {
            $abonnement = new Abonnement(
                $row['type_abonnement'],
                $row['date_debut'],
                $row['date_fin'],
                $row['id_adherent'],
                $row['id_abonnement']
            );
            $abonnements[] = $abonnement;
        }
        
        return $abonnements;
    }
    
    public function findById(int $id): ?Abonnement
    {
        $stmt = $this->db->prepare('
            SELECT a.*, ad.nom, ad.prenom 
            FROM ABONNEMENT a 
            LEFT JOIN ADHERENT ad ON a.id_adherent = ad.id_adherent 
            WHERE a.id_abonnement = :id
        ');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        
        if (!$row) {
            return null;
        }
        
        return new Abonnement(
            $row['type_abonnement'],
            $row['date_debut'],
            $row['date_fin'],
            $row['id_adherent'],
            $row['id_abonnement']
        );
    }
    
    public function findByAdherent(int $idAdherent): array
    {
        $stmt = $this->db->prepare('
            SELECT * 
            FROM ABONNEMENT 
            WHERE id_adherent = :idAdherent 
            ORDER BY date_debut DESC
        ');
        $stmt->execute(['idAdherent' => $idAdherent]);
        
        $abonnements = [];
        while ($row = $stmt->fetch()) {
            $abonnement = new Abonnement(
                $row['type_abonnement'],
                $row['date_debut'],
                $row['date_fin'],
                $row['id_adherent'],
                $row['id_abonnement']
            );
            $abonnements[] = $abonnement;
        }
        
        return $abonnements;
    }
    
    public function findActiveByAdherent(int $idAdherent): ?Abonnement
    {
        $stmt = $this->db->prepare('
            SELECT * 
            FROM ABONNEMENT 
            WHERE id_adherent = :idAdherent 
            AND date_debut <= CURDATE() 
            AND date_fin >= CURDATE()
            ORDER BY date_fin DESC 
            LIMIT 1
        ');
        $stmt->execute(['idAdherent' => $idAdherent]);
        $row = $stmt->fetch();
        
        if (!$row) {
            return null;
        }
        
        return new Abonnement(
            $row['type_abonnement'],
            $row['date_debut'],
            $row['date_fin'],
            $row['id_adherent'],
            $row['id_abonnement']
        );
    }
    
    public function create(Abonnement $abonnement): int
    {
        $stmt = $this->db->prepare('
            INSERT INTO ABONNEMENT (type_abonnement, date_debut, date_fin, id_adherent)
            VALUES (:type_abonnement, :date_debut, :date_fin, :id_adherent)
        ');
        
        $stmt->execute([
            'type_abonnement' => $abonnement->getTypeAbonnement(),
            'date_debut' => $abonnement->getDateDebut(),
            'date_fin' => $abonnement->getDateFin(),
            'id_adherent' => $abonnement->getIdAdherent()
        ]);
        
        return (int) $this->db->lastInsertId();
    }
    
    public function update(Abonnement $abonnement): bool
    {
        $stmt = $this->db->prepare('
            UPDATE ABONNEMENT 
            SET type_abonnement = :type_abonnement, 
                date_debut = :date_debut, 
                date_fin = :date_fin
            WHERE id_abonnement = :id
        ');
        
        return $stmt->execute([
            'type_abonnement' => $abonnement->getTypeAbonnement(),
            'date_debut' => $abonnement->getDateDebut(),
            'date_fin' => $abonnement->getDateFin(),
            'id' => $abonnement->getIdAbonnement()
        ]);
    }
    
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM ABONNEMENT WHERE id_abonnement = :id');
        return $stmt->execute(['id' => $id]);
    }
}
