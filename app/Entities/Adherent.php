<?php

namespace App\Entities;

class Adherent
{
    private int $id_adherent;
    private string $nom;
    private string $prenom;
    private string $email;
    private ?string $telephone;
    private string $date_inscription;
    private int $id_salle;
    
    public function __construct(
        string $nom,
        string $prenom,
        string $email,
        string $date_inscription,
        int $id_salle,
        ?string $telephone = null,
        ?int $id_adherent = null
    ) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->date_inscription = $date_inscription;
        $this->id_salle = $id_salle;
        $this->id_adherent = $id_adherent ?? 0;
    }
    
    public function getIdAdherent(): int
    {
        return $this->id_adherent;
    }
    
    public function setIdAdherent(int $id_adherent): void
    {
        $this->id_adherent = $id_adherent;
    }
    
    public function getNom(): string
    {
        return $this->nom;
    }
    
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }
    
    public function getPrenom(): string
    {
        return $this->prenom;
    }
    
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }
    
    public function getEmail(): string
    {
        return $this->email;
    }
    
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }
    
    public function setTelephone(?string $telephone): void
    {
        $this->telephone = $telephone;
    }
    
    public function getDateInscription(): string
    {
        return $this->date_inscription;
    }
    
    public function setDateInscription(string $date_inscription): void
    {
        $this->date_inscription = $date_inscription;
    }
    
    public function getIdSalle(): int
    {
        return $this->id_salle;
    }
    
    public function setIdSalle(int $id_salle): void
    {
        $this->id_salle = $id_salle;
    }
    
    public function toArray(): array
    {
        return [
            'id_adherent' => $this->id_adherent,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'date_inscription' => $this->date_inscription,
            'id_salle' => $this->id_salle
        ];
    }
}
