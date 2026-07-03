<?php

/**
 * AbonnementController — orchestre AbonnementService, AdherentService
 * et les vues pour tout ce qui concerne les abonnements.
 */
class AbonnementController
{
    private AbonnementService $abonnementService;
    private AdherentService $adherentService;

    public function __construct(AbonnementService $abonnementService, AdherentService $adherentService)
    {
        $this->abonnementService = $abonnementService;
        $this->adherentService = $adherentService;
    }

    /** GET /?page=abonnements */
    public function index(): void
    {
        $abonnements = $this->abonnementService->listerTous();
        $adherents = $this->adherentService->listerTous();
        $adherentsParId = [];
        foreach ($adherents as $a) {
            $adherentsParId[$a->getIdAdherent()] = $a->getNomComplet();
        }

        require __DIR__ . '/../../views/abonnements/index.php';
    }

    /** GET /?page=abonnements&action=create */
    public function create(): void
    {
        $adherents = $this->adherentService->listerTous();
        $erreur = null;
        require __DIR__ . '/../../views/abonnements/create.php';
    }

    /** POST /?page=abonnements&action=store */
    public function store(): void
    {
        $adherents = $this->adherentService->listerTous();
        $erreur = null;

        try {
            $this->abonnementService->souscrire($_POST);
            header('Location: index.php?page=abonnements&success=1');
            exit;
        } catch (Throwable $e) {
            $erreur = $e->getMessage();
            require __DIR__ . '/../../views/abonnements/create.php';
        }
    }
}
