<?php

/**
 * AdherentController — orchestre AdherentService, SalleRepository
 * et les vues pour tout ce qui concerne les adhérents.
 */
class AdherentController
{
    private AdherentService $adherentService;
    private SalleRepository $salleRepository;

    public function __construct(AdherentService $adherentService, SalleRepository $salleRepository)
    {
        $this->adherentService = $adherentService;
        $this->salleRepository = $salleRepository;
    }

    /** GET /?page=adherents */
    public function index(): void
    {
        $adherents = $this->adherentService->listerTous();
        $salles = $this->salleRepository->findAll();
        // index par id pour affichage rapide du nom de salle dans la vue
        $sallesParId = [];
        foreach ($salles as $s) {
            $sallesParId[$s['id_salle']] = $s['nom'];
        }

        require __DIR__ . '/../../views/adherents/index.php';
    }

    /** GET /?page=adherents&action=create */
    public function create(): void
    {
        $salles = $this->salleRepository->findAll();
        $erreur = null;
        require __DIR__ . '/../../views/adherents/create.php';
    }

    /** POST /?page=adherents&action=store */
    public function store(): void
    {
        $salles = $this->salleRepository->findAll();
        $erreur = null;

        try {
            $this->adherentService->inscrire($_POST);
            header('Location: index.php?page=adherents&success=1');
            exit;
        } catch (Throwable $e) {
            $erreur = $e->getMessage();
            require __DIR__ . '/../../views/adherents/create.php';
        }
    }

    /** POST /?page=adherents&action=delete&id=X */
    public function delete(int $id): void
    {
        try {
            $this->adherentService->supprimer($id);
            header('Location: index.php?page=adherents&success=2');
        } catch (Throwable $e) {
            header('Location: index.php?page=adherents&error=' . urlencode($e->getMessage()));
        }
        exit;
    }
}
