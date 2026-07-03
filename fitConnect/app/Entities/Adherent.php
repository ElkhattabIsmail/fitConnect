<?php

/**
 * Entité Adherent — encapsule les attributs et comportements
 * métier liés à un adhérent, indépendamment de la persistance.
 */
class Adherent
{
    private ?int $idAdherent;
    private string $nom;
    private string $prenom;
    private string $email;
    private ?string $telephone;
    private ?string $dateNaissance;
    private string $dateInscription;
    private int $idSalle;

    public function __construct(
        ?int $idAdherent,
        string $nom,
        string $prenom,
        string $email,
        ?string $telephone,
        ?string $dateNaissance,
        string $dateInscription,
        int $idSalle
    ) {
        $this->idAdherent = $idAdherent;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->setEmail($email);
        $this->telephone = $telephone;
        $this->dateNaissance = $dateNaissance;
        $this->dateInscription = $dateInscription;
        $this->idSalle = $idSalle;
    }

    // ---- Getters ----
    public function getIdAdherent(): ?int { return $this->idAdherent; }
    public function getNom(): string { return $this->nom; }
    public function getPrenom(): string { return $this->prenom; }
    public function getEmail(): string { return $this->email; }
    public function getTelephone(): ?string { return $this->telephone; }
    public function getDateNaissance(): ?string { return $this->dateNaissance; }
    public function getDateInscription(): string { return $this->dateInscription; }
    public function getIdSalle(): int { return $this->idSalle; }

    public function getNomComplet(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    // ---- Setters (avec validation métier légère) ----
    public function setNom(string $nom): void { $this->nom = trim($nom); }
    public function setPrenom(string $prenom): void { $this->prenom = trim($prenom); }

    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email invalide : {$email}");
        }
        $this->email = $email;
    }

    public function setTelephone(?string $telephone): void { $this->telephone = $telephone; }
    public function setDateNaissance(?string $dateNaissance): void { $this->dateNaissance = $dateNaissance; }
    public function setIdSalle(int $idSalle): void { $this->idSalle = $idSalle; }
    public function setIdAdherent(int $idAdherent): void { $this->idAdherent = $idAdherent; }

    /**
     * Construit une instance à partir d'une ligne de résultat PDO (tableau associatif).
     */
    public static function fromArray(array $row): self
    {
        return new self(
            (int) $row['id_adherent'],
            $row['nom'],
            $row['prenom'],
            $row['email'],
            $row['telephone'] ?? null,
            $row['date_naissance'] ?? null,
            $row['date_inscription'],
            (int) $row['id_salle']
        );
    }

    public function toArray(): array
    {
        return [
            'id_adherent'      => $this->idAdherent,
            'nom'              => $this->nom,
            'prenom'           => $this->prenom,
            'email'            => $this->email,
            'telephone'        => $this->telephone,
            'date_naissance'   => $this->dateNaissance,
            'date_inscription' => $this->dateInscription,
            'id_salle'         => $this->idSalle,
        ];
    }
}
