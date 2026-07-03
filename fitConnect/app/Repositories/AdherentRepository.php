<?php

/**
 * AdherentRepository — unique responsable de l'accès aux données
 * de la table `adherents`. Toutes les requêtes sont paramétrées.
 */
class AdherentRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query(
            'SELECT * FROM adherents ORDER BY nom, prenom'
        );
        return array_map(fn($row) => Adherent::fromArray($row), $stmt->fetchAll());
    }

    public function findById(int $id): ?Adherent
    {
        $stmt = $this->pdo->prepare('SELECT * FROM adherents WHERE id_adherent = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? Adherent::fromArray($row) : null;
    }

    public function findByEmail(string $email): ?Adherent
    {
        $stmt = $this->pdo->prepare('SELECT * FROM adherents WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();
        return $row ? Adherent::fromArray($row) : null;
    }

    public function create(Adherent $adherent): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO adherents (nom, prenom, email, telephone, date_naissance, date_inscription, id_salle)
             VALUES (:nom, :prenom, :email, :telephone, :date_naissance, :date_inscription, :id_salle)'
        );
        $stmt->execute([
            'nom'              => $adherent->getNom(),
            'prenom'           => $adherent->getPrenom(),
            'email'            => $adherent->getEmail(),
            'telephone'        => $adherent->getTelephone(),
            'date_naissance'   => $adherent->getDateNaissance(),
            'date_inscription' => $adherent->getDateInscription(),
            'id_salle'         => $adherent->getIdSalle(),
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function update(Adherent $adherent): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE adherents
             SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone,
                 date_naissance = :date_naissance, id_salle = :id_salle
             WHERE id_adherent = :id'
        );
        return $stmt->execute([
            'nom'            => $adherent->getNom(),
            'prenom'         => $adherent->getPrenom(),
            'email'          => $adherent->getEmail(),
            'telephone'      => $adherent->getTelephone(),
            'date_naissance' => $adherent->getDateNaissance(),
            'id_salle'       => $adherent->getIdSalle(),
            'id'             => $adherent->getIdAdherent(),
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM adherents WHERE id_adherent = :id');
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Compte le nombre de séances liées à un adhérent (utilisé pour la règle
     * "un adhérent avec des séances ne peut pas être supprimé").
     */
    public function countSeances(int $idAdherent): int
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM seances WHERE id_adherent = :id');
        $stmt->execute(['id' => $idAdherent]);
        return (int) $stmt->fetchColumn();
    }

    /**
     * Compte les abonnements en cours (statut actif) d'un adhérent.
     */
    public function countAbonnementsActifs(int $idAdherent): int
    {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) FROM abonnements WHERE id_adherent = :id AND statut = 'actif'"
        );
        $stmt->execute(['id' => $idAdherent]);
        return (int) $stmt->fetchColumn();
    }
}
