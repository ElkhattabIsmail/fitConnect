<?php

/**
 * SeanceController — orchestre SeanceService et les référentiels
 * (salles, activités, équipements) pour l'enregistrement des séances.
 */
class SeanceController
{
    private SeanceService $seanceService;
    private AdherentService $adherentService;
    private SalleRepository $salleRepository;
    private ReferentielRepository $referentielRepository;

    public function __construct(
        SeanceService $seanceService,
        AdherentService $adherentService,
        SalleRepository $salleRepository,
        ReferentielRepository $referentielRepository
    ) {
        $this->seanceService = $seanceService;
        $this->adherentService = $adherentService;
        $this->salleRepository = $salleRepository;
        $this->referentielRepository = $referentielRepository;
    }

    /** GET /?page=seances */
    public function index(): void
    {
        $seances = $this->seanceService->listerToutes();
        require __DIR__ . '/../../views/seances/index.php';
    }

    /** GET /?page=seances&action=create */
    public function create(): void
    {
        $adherents = $this->adherentService->listerTous();
        $salles = $this->salleRepository->findAll();
        $activites = $this->referentielRepository->findAllActivites();
        $erreur = null;
        require __DIR__ . '/../../views/seances/create.php';
    }

    /** POST /?page=seances&action=store */
    public function store(): void
    {
        $adherents = $this->adherentService->listerTous();
        $salles = $this->salleRepository->findAll();
        $activites = $this->referentielRepository->findAllActivites();
        $erreur = null;

        try {
            $this->seanceService->enregistrer($_POST);
            header('Location: index.php?page=seances&success=1');
            exit;
        } catch (Throwable $e) {
            $erreur = $e->getMessage();
            require __DIR__ . '/../../views/seances/create.php';
        }
    }
}
