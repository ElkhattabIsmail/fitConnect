<?php

namespace App\Controllers;

use App\Services\AbonnementService;
use App\Entities\Abonnement;
use Exception;

class AbonnementController
{
    private AbonnementService $abonnementService;
    private string $baseUrl;
    
    public function __construct()
    {
        $this->abonnementService = new AbonnementService();
        $this->baseUrl = $_SERVER['SCRIPT_NAME'];
    }
    
    public function index(): void
    {
        global $baseUrl;
        $baseUrl = $this->baseUrl;
        $abonnements = $this->abonnementService->getAllAbonnements();
        require __DIR__ . '/../../views/abonnements/index.php';
    }
    
    public function create(): void
    {
        global $baseUrl;
        $baseUrl = $this->baseUrl;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $abonnement = new Abonnement(
                    $_POST['type_abonnement'],
                    $_POST['date_debut'],
                    $_POST['date_fin'],
                    (int) $_POST['id_adherent']
                );
                
                $this->abonnementService->createAbonnement($abonnement);
                header('Location: ' . $this->baseUrl . '?route=abonnements');
                exit;
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        
        require __DIR__ . '/../../views/abonnements/create.php';
    }
    
    public function edit(int $id): void
    {
        global $baseUrl;
        $baseUrl = $this->baseUrl;
        
        $abonnement = $this->abonnementService->getAbonnementById($id);
        
        if (!$abonnement) {
            header('Location: ' . $this->baseUrl . '?route=abonnements');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $abonnement->setTypeAbonnement($_POST['type_abonnement']);
                $abonnement->setDateDebut($_POST['date_debut']);
                $abonnement->setDateFin($_POST['date_fin']);
                
                $this->abonnementService->updateAbonnement($abonnement);
                header('Location: ' . $this->baseUrl . '?route=abonnements');
                exit;
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        
        require __DIR__ . '/../../views/abonnements/edit.php';
    }
    
    public function delete(int $id): void
    {
        global $baseUrl;
        $baseUrl = $this->baseUrl;
        
        try {
            $this->abonnementService->deleteAbonnement($id);
            header('Location: ' . $this->baseUrl . '?route=abonnements');
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
            $abonnements = $this->abonnementService->getAllAbonnements();
            require __DIR__ . '/../../views/abonnements/index.php';
        }
    }
    
    public function show(int $id): void
    {
        global $baseUrl;
        $baseUrl = $this->baseUrl;
        
        $abonnement = $this->abonnementService->getAbonnementById($id);
        
        if (!$abonnement) {
            header('Location: ' . $this->baseUrl . '?route=abonnements');
            exit;
        }
        
        require __DIR__ . '/../../views/abonnements/show.php';
    }
}
