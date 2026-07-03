<?php

namespace App\Entities;

class Seance
{
    private int $id_seance;
    private string $date_seance;
    private int $duree;
    private int $id_adherent;
    private int $id_salle;
    private ?int $id_activite;
    private ?int $id_equipement;
    private ?string $nom_salle;
    private ?string $activite_libelle;
    private ?string $nom_equipement;
    
    public function __construct(
        string $date_seance,
        int $duree,
        int $id_adherent,
        int $id_salle,
        ?int $id_activite = null,
        ?int $id_equipement = null,
        ?int $id_seance = null
    ) {
        $this->date_seance = $date_seance;
        $this->duree = $duree;
        $this->id_adherent = $id_adherent;
        $this->id_salle = $id_salle;
        $this->id_activite = $id_activite;
        $this->id_equipement = $id_equipement;
        $this->id_seance = $id_seance ?? 0;
    }
    
    public function getIdSeance(): int
    {
        return $this->id_seance;
    }
    
    public function setIdSeance(int $id_seance): void
    {
        $this->id_seance = $id_seance;
    }
    
    public function getDateSeance(): string
    {
        return $this->date_seance;
    }
    
    public function setDateSeance(string $date_seance): void
    {
        $this->date_seance = $date_seance;
    }
    
    public function getDuree(): int
    {
        return $this->duree;
    }
    
    public function setDuree(int $duree): void
    {
        if ($duree <= 0) {
            throw new \InvalidArgumentException('La durée doit être positive');
        }
        $this->duree = $duree;
    }
    
    public function getIdAdherent(): int
    {
        return $this->id_adherent;
    }
    
    public function setIdAdherent(int $id_adherent): void
    {
        $this->id_adherent = $id_adherent;
    }
    
    public function getIdSalle(): int
    {
        return $this->id_salle;
    }
    
    public function setIdSalle(int $id_salle): void
    {
        $this->id_salle = $id_salle;
    }
    
    public function getIdActivite(): ?int
    {
        return $this->id_activite;
    }
    
    public function setIdActivite(?int $id_activite): void
    {
        $this->id_activite = $id_activite;
    }
    
    public function getIdEquipement(): ?int
    {
        return $this->id_equipement;
    }
    
    public function setIdEquipement(?int $id_equipement): void
    {
        $this->id_equipement = $id_equipement;
    }
    
    public function getNomSalle(): ?string
    {
        return $this->nom_salle;
    }
    
    public function setNomSalle(?string $nom_salle): void
    {
        $this->nom_salle = $nom_salle;
    }
    
    public function getActiviteLibelle(): ?string
    {
        return $this->activite_libelle;
    }
    
    public function setActiviteLibelle(?string $activite_libelle): void
    {
        $this->activite_libelle = $activite_libelle;
    }
    
    public function getNomEquipement(): ?string
    {
        return $this->nom_equipement;
    }
    
    public function setNomEquipement(?string $nom_equipement): void
    {
        $this->nom_equipement = $nom_equipement;
    }
    
    public function toArray(): array
    {
        return [
            'id_seance' => $this->id_seance,
            'date_seance' => $this->date_seance,
            'duree' => $this->duree,
            'id_adherent' => $this->id_adherent,
            'id_salle' => $this->id_salle,
            'id_activite' => $this->id_activite,
            'id_equipement' => $this->id_equipement,
            'nom_salle' => $this->nom_salle,
            'activite_libelle' => $this->activite_libelle,
            'nom_equipement' => $this->nom_equipement
        ];
    }
}
