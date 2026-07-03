<?php

/**
 * SeanceRepository — accès aux données de la table `seances`.
 */
class SeanceRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM seances ORDER BY date_seance DESC');
        return array_map(fn($row) => Seance::fromArray($row), $stmt->fetchAll());
    }

    /**
     * Liste enrichie (jointures) pour l'affichage dans les vues et le dashboard.
     */
    public function findAllDetaillees(int $limit = 50): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT s.*, a.nom AS adherent_nom, a.prenom AS adherent_prenom,
                    sa.nom AS salle_nom, t.nom AS activite_nom, e.nom AS equipement_nom
             FROM seances s
             JOIN adherents a ON a.id_adherent = s.id_adherent
             JOIN salles sa ON sa.id_salle = s.id_salle
             JOIN types_activite t ON t.id_activite = s.id_activite
             LEFT JOIN equipements e ON e.id_equipement = s.id_equipement
             ORDER BY s.date_seance DESC
             LIMIT :limit'
        );
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?Seance
    {
        $stmt = $this->pdo->prepare('SELECT * FROM seances WHERE id_seance = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? Seance::fromArray($row) : null;
    }

    public function findByAdherent(int $idAdherent): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM seances WHERE id_adherent = :id ORDER BY date_seance DESC'
        );
        $stmt->execute(['id' => $idAdherent]);
        return array_map(fn($row) => Seance::fromArray($row), $stmt->fetchAll());
    }

    public function create(Seance $seance): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO seances (id_adherent, id_salle, id_activite, id_equipement, duree_minutes, date_seance)
             VALUES (:id_adherent, :id_salle, :id_activite, :id_equipement, :duree_minutes, :date_seance)'
        );
        $stmt->execute([
            'id_adherent'   => $seance->getIdAdherent(),
            'id_salle'      => $seance->getIdSalle(),
            'id_activite'   => $seance->getIdActivite(),
            'id_equipement' => $seance->getIdEquipement(),
            'duree_minutes' => $seance->getDureeMinutes(),
            'date_seance'   => $seance->getDateSeance(),
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function countTotal(): int
    {
        return (int) $this->pdo->query('SELECT COUNT(*) FROM seances')->fetchColumn();
    }

    public function countByMonth(): array
    {
        $stmt = $this->pdo->query(
            "SELECT DATE_FORMAT(date_seance, '%Y-%m') AS mois, COUNT(*) AS total
             FROM seances GROUP BY mois ORDER BY mois DESC LIMIT 6"
        );
        return $stmt->fetchAll();
    }
}
