<?php

/**
 * Entité Abonnement — encapsule les règles de validité
 * d'un abonnement (mensuel / trimestriel / annuel).
 */
class Abonnement
{
    public const TYPE_MENSUEL     = 'mensuel';
    public const TYPE_TRIMESTRIEL = 'trimestriel';
    public const TYPE_ANNUEL      = 'annuel';

    public const STATUT_ACTIF   = 'actif';
    public const STATUT_EXPIRE  = 'expire';
    public const STATUT_RESILIE = 'resilie';

    private ?int $idAbonnement;
    private string $type;
    private string $dateDebut;
    private string $dateFin;
    private string $statut;
    private int $idAdherent;

    public function __construct(
        ?int $idAbonnement,
        string $type,
        string $dateDebut,
        string $dateFin,
        string $statut,
        int $idAdherent
    ) {
        $this->idAbonnement = $idAbonnement;
        $this->setType($type);
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->statut = $statut;
        $this->idAdherent = $idAdherent;
    }

    // ---- Getters ----
    public function getIdAbonnement(): ?int { return $this->idAbonnement; }
    public function getType(): string { return $this->type; }
    public function getDateDebut(): string { return $this->dateDebut; }
    public function getDateFin(): string { return $this->dateFin; }
    public function getStatut(): string { return $this->statut; }
    public function getIdAdherent(): int { return $this->idAdherent; }

    // ---- Setters ----
    public function setType(string $type): void
    {
        $valides = [self::TYPE_MENSUEL, self::TYPE_TRIMESTRIEL, self::TYPE_ANNUEL];
        if (!in_array($type, $valides, true)) {
            throw new InvalidArgumentException("Type d'abonnement invalide : {$type}");
        }
        $this->type = $type;
    }

    public function setStatut(string $statut): void { $this->statut = $statut; }
    public function setIdAbonnement(int $id): void { $this->idAbonnement = $id; }

    /**
     * Vérifie si l'abonnement est valide à une date donnée (par défaut : aujourd'hui).
     * Règle métier centrale : utilisée par SeanceService avant d'enregistrer une séance.
     */
    public function estValide(?string $date = null): bool
    {
        $date = $date ?? date('Y-m-d');
        return $this->statut === self::STATUT_ACTIF
            && $date >= $this->dateDebut
            && $date <= $this->dateFin;
    }

    public static function fromArray(array $row): self
    {
        return new self(
            (int) $row['id_abonnement'],
            $row['type'],
            $row['date_debut'],
            $row['date_fin'],
            $row['statut'],
            (int) $row['id_adherent']
        );
    }

    public function toArray(): array
    {
        return [
            'id_abonnement' => $this->idAbonnement,
            'type'          => $this->type,
            'date_debut'    => $this->dateDebut,
            'date_fin'      => $this->dateFin,
            'statut'        => $this->statut,
            'id_adherent'   => $this->idAdherent,
        ];
    }
}
