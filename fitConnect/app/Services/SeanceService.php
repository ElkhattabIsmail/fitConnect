<?php

/**
 * SeanceService — applique la règle de gestion centrale :
 * "une séance ne peut être enregistrée que si l'abonnement
 * de l'adhérent est valide à la date du jour".
 */
class SeanceService
{
    private SeanceRepository $seanceRepository;
    private AbonnementService $abonnementService;
    private AdherentRepository $adherentRepository;

    public function __construct(
        SeanceRepository $seanceRepository,
        AbonnementService $abonnementService,
        AdherentRepository $adherentRepository
    ) {
        $this->seanceRepository = $seanceRepository;
        $this->abonnementService = $abonnementService;
        $this->adherentRepository = $adherentRepository;
    }

    public function listerToutes(int $limit = 50): array
    {
        return $this->seanceRepository->findAllDetaillees($limit);
    }

    public function historiqueParAdherent(int $idAdherent): array
    {
        return $this->seanceRepository->findByAdherent($idAdherent);
    }

    /**
     * Enregistre une séance après vérification de la validité
     * de l'abonnement de l'adhérent.
     *
     * @throws RuntimeException si l'adhérent n'existe pas ou son abonnement n'est pas valide
     */
    public function enregistrer(array $donnees): int
    {
        $idAdherent = (int) $donnees['id_adherent'];

        if (!$this->adherentRepository->findById($idAdherent)) {
            throw new RuntimeException("Adhérent introuvable (id={$idAdherent}).");
        }

        if (!$this->abonnementService->estAdherentValide($idAdherent)) {
            throw new RuntimeException(
                "Séance refusée : l'abonnement de cet adhérent n'est pas valide à la date du jour."
            );
        }

        $seance = new Seance(
            null,
            $idAdherent,
            (int) $donnees['id_salle'],
            (int) $donnees['id_activite'],
            isset($donnees['id_equipement']) && $donnees['id_equipement'] !== ''
                ? (int) $donnees['id_equipement']
                : null,
            (int) $donnees['duree_minutes'],
            $donnees['date_seance'] ?? date('Y-m-d H:i:s')
        );

        return $this->seanceRepository->create($seance);
    }

    public function statistiquesGlobales(): array
    {
        return [
            'total_seances'    => $this->seanceRepository->countTotal(),
            'seances_par_mois' => $this->seanceRepository->countByMonth(),
        ];
    }
}
