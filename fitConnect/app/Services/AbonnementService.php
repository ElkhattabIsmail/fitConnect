<?php

/**
 * AbonnementService — applique les règles de gestion des abonnements,
 * en particulier : "un adhérent ne détient qu'un seul abonnement
 * actif à la fois".
 */
class AbonnementService
{
    private AbonnementRepository $abonnementRepository;
    private AdherentRepository $adherentRepository;

    private const DUREES_JOURS = [
        Abonnement::TYPE_MENSUEL     => 30,
        Abonnement::TYPE_TRIMESTRIEL => 90,
        Abonnement::TYPE_ANNUEL      => 365,
    ];

    public function __construct(
        AbonnementRepository $abonnementRepository,
        AdherentRepository $adherentRepository
    ) {
        $this->abonnementRepository = $abonnementRepository;
        $this->adherentRepository = $adherentRepository;
    }

    public function listerTous(): array
    {
        return $this->abonnementRepository->findAll();
    }

    public function historiqueParAdherent(int $idAdherent): array
    {
        return $this->abonnementRepository->findByAdherent($idAdherent);
    }

    /**
     * Souscrit un nouvel abonnement pour un adhérent.
     * Si un abonnement actif existe déjà, il est automatiquement résilié
     * (règle : un seul abonnement actif à la fois).
     */
    public function souscrire(array $donnees): int
    {
        $idAdherent = (int) $donnees['id_adherent'];

        if (!$this->adherentRepository->findById($idAdherent)) {
            throw new RuntimeException("Adhérent introuvable (id={$idAdherent}).");
        }

        $type = $donnees['type'];
        if (!isset(self::DUREES_JOURS[$type])) {
            throw new InvalidArgumentException("Type d'abonnement invalide : {$type}");
        }

        $dateDebut = $donnees['date_debut'] ?? date('Y-m-d');
        $dateFin = $donnees['date_fin'] ?? date('Y-m-d', strtotime($dateDebut . ' + ' . self::DUREES_JOURS[$type] . ' days'));

        // Un adhérent ne peut avoir qu'un seul abonnement actif : on résilie l'ancien
        $this->abonnementRepository->resilierActifsByAdherent($idAdherent);

        $abonnement = new Abonnement(
            null,
            $type,
            $dateDebut,
            $dateFin,
            Abonnement::STATUT_ACTIF,
            $idAdherent
        );

        return $this->abonnementRepository->create($abonnement);
    }

    /**
     * Vérifie si un adhérent possède un abonnement valide aujourd'hui.
     * Utilisée par SeanceService avant d'enregistrer une séance.
     */
    public function estAdherentValide(int $idAdherent): bool
    {
        $abonnement = $this->abonnementRepository->findActifByAdherent($idAdherent);
        return $abonnement !== null && $abonnement->estValide();
    }

    public function resilier(int $idAbonnement): bool
    {
        return $this->abonnementRepository->updateStatut($idAbonnement, Abonnement::STATUT_RESILIE);
    }
}
