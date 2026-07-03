<?php

namespace App\Entities;

class Abonnement
{
    private int $id_abonnement;
    private string $type_abonnement;
    private string $date_debut;
    private string $date_fin;
    private int $id_adherent;
    
    public function __construct(
        string $type_abonnement,
        string $date_debut,
        string $date_fin,
        int $id_adherent,
        ?int $id_abonnement = null
    ) {
        $this->type_abonnement = $type_abonnement;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
        $this->id_adherent = $id_adherent;
        $this->id_abonnement = $id_abonnement ?? 0;
    }
    
    public function getIdAbonnement(): int
    {
        return $this->id_abonnement;
    }
    
    public function setIdAbonnement(int $id_abonnement): void
    {
        $this->id_abonnement = $id_abonnement;
    }
    
    public function getTypeAbonnement(): string
    {
        return $this->type_abonnement;
    }
    
    public function setTypeAbonnement(string $type_abonnement): void
    {
        if (!in_array($type_abonnement, ['mensuel', 'trimestriel', 'annuel'])) {
            throw new \InvalidArgumentException('Type d\'abonnement invalide');
        }
        $this->type_abonnement = $type_abonnement;
    }
    
    public function getDateDebut(): string
    {
        return $this->date_debut;
    }
    
    public function setDateDebut(string $date_debut): void
    {
        $this->date_debut = $date_debut;
    }
    
    public function getDateFin(): string
    {
        return $this->date_fin;
    }
    
    public function setDateFin(string $date_fin): void
    {
        $this->date_fin = $date_fin;
    }
    
    public function getIdAdherent(): int
    {
        return $this->id_adherent;
    }
    
    public function setIdAdherent(int $id_adherent): void
    {
        $this->id_adherent = $id_adherent;
    }
    
    public function isValid(string $date = null): bool
    {
        $checkDate = $date ?? date('Y-m-d');
        return $checkDate >= $this->date_debut && $checkDate <= $this->date_fin;
    }
    
    public function toArray(): array
    {
        return [
            'id_abonnement' => $this->id_abonnement,
            'type_abonnement' => $this->type_abonnement,
            'date_debut' => $this->date_debut,
            'date_fin' => $this->date_fin,
            'id_adherent' => $this->id_adherent
        ];
    }
}
