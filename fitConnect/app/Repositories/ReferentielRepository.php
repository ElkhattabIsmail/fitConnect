<?php

/**
 * ReferentielRepository — regroupe l'accès aux tables de référence
 * `types_activite` et `equipements`, utilisées principalement
 * pour peupler les listes déroulantes des formulaires.
 */
class ReferentielRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAllActivites(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM types_activite ORDER BY nom');
        return $stmt->fetchAll();
    }

    public function findEquipementsBySalle(int $idSalle): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM equipements WHERE id_salle = :id ORDER BY nom');
        $stmt->execute(['id' => $idSalle]);
        return $stmt->fetchAll();
    }
}
