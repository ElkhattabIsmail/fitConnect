<?php

/**
 * AbonnementRepository — accès aux données de la table `abonnements`.
 */
class AbonnementRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM abonnements ORDER BY date_debut DESC');
        return array_map(fn($row) => Abonnement::fromArray($row), $stmt->fetchAll());
    }

    public function findById(int $id): ?Abonnement
    {
        $stmt = $this->pdo->prepare('SELECT * FROM abonnements WHERE id_abonnement = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? Abonnement::fromArray($row) : null;
    }

    /**
     * Récupère l'abonnement actif courant d'un adhérent (s'il existe).
     */
    public function findActifByAdherent(int $idAdherent): ?Abonnement
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM abonnements
             WHERE id_adherent = :id AND statut = 'actif'
             ORDER BY date_fin DESC LIMIT 1"
        );
        $stmt->execute(['id' => $idAdherent]);
        $row = $stmt->fetch();
        return $row ? Abonnement::fromArray($row) : null;
    }

    public function findByAdherent(int $idAdherent): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM abonnements WHERE id_adherent = :id ORDER BY date_debut DESC'
        );
        $stmt->execute(['id' => $idAdherent]);
        return array_map(fn($row) => Abonnement::fromArray($row), $stmt->fetchAll());
    }

    public function create(Abonnement $abonnement): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO abonnements (type, date_debut, date_fin, statut, id_adherent)
             VALUES (:type, :date_debut, :date_fin, :statut, :id_adherent)'
        );
        $stmt->execute([
            'type'        => $abonnement->getType(),
            'date_debut'  => $abonnement->getDateDebut(),
            'date_fin'    => $abonnement->getDateFin(),
            'statut'      => $abonnement->getStatut(),
            'id_adherent' => $abonnement->getIdAdherent(),
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Passe tous les abonnements actifs d'un adhérent à "résilié"
     * (utilisé avant de souscrire un nouvel abonnement).
     */
    public function resilierActifsByAdherent(int $idAdherent): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE abonnements SET statut = 'resilie'
             WHERE id_adherent = :id AND statut = 'actif'"
        );
        return $stmt->execute(['id' => $idAdherent]);
    }

    public function updateStatut(int $id, string $statut): bool
    {
        $stmt = $this->pdo->prepare('UPDATE abonnements SET statut = :statut WHERE id_abonnement = :id');
        return $stmt->execute(['statut' => $statut, 'id' => $id]);
    }
}
