<?php

namespace App\Controllers;

use App\Services\SeanceService;
use App\Entities\Seance;
use Exception;

class SeanceController
{
    private SeanceService $seanceService;
    private string $baseUrl;
    
    public function __construct()
    {
        $this->seanceService = new SeanceService();
        $this->baseUrl = $_SERVER['SCRIPT_NAME'];
    }
    
    public function index(): void
    {
        global $baseUrl;
        $baseUrl = $this->baseUrl;
        $seances = $this->seanceService->getAllSeances();
        require __DIR__ . '/../../views/dashboard/index.php';
    }
    
    public function create(): void
    {
        global $baseUrl;
        $baseUrl = $this->baseUrl;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $seance = new Seance(
                    $_POST['date_seance'],
                    (int) $_POST['duree'],
                    (int) $_POST['id_adherent'],
                    (int) $_POST['id_salle'],
                    !empty($_POST['id_activite']) ? (int) $_POST['id_activite'] : null,
                    !empty($_POST['id_equipement']) ? (int) $_POST['id_equipement'] : null
                );
                
                $this->seanceService->createSeance($seance);
                header('Location: ' . $this->baseUrl . '?route=dashboard');
                exit;
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        
        require __DIR__ . '/../../views/dashboard/create.php';
    }
    
    public function edit(int $id): void
    {
        global $baseUrl;
        $baseUrl = $this->baseUrl;
        
        $seance = $this->seanceService->getSeanceById($id);
        
        if (!$seance) {
            header('Location: ' . $this->baseUrl . '?route=dashboard');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $seance->setDateSeance($_POST['date_seance']);
                $seance->setDuree((int) $_POST['duree']);
                $seance->setIdAdherent((int) $_POST['id_adherent']);
                $seance->setIdSalle((int) $_POST['id_salle']);
                $seance->setIdActivite(!empty($_POST['id_activite']) ? (int) $_POST['id_activite'] : null);
                $seance->setIdEquipement(!empty($_POST['id_equipement']) ? (int) $_POST['id_equipement'] : null);
                
                $this->seanceService->updateSeance($seance);
                header('Location: ' . $this->baseUrl . '?route=dashboard');
                exit;
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        
        require __DIR__ . '/../../views/dashboard/edit.php';
    }
    
    public function delete(int $id): void
    {
        global $baseUrl;
        $baseUrl = $this->baseUrl;
        
        try {
            $this->seanceService->deleteSeance($id);
            header('Location: ' . $this->baseUrl . '?route=dashboard');
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
            $seances = $this->seanceService->getAllSeances();
            require __DIR__ . '/../../views/dashboard/index.php';
        }
    }
    
    public function show(int $id): void
    {
        global $baseUrl;
        $baseUrl = $this->baseUrl;
        
        $seance = $this->seanceService->getSeanceById($id);
        
        if (!$seance) {
            header('Location: ' . $this->baseUrl . '?route=dashboard');
            exit;
        }
        
        require __DIR__ . '/../../views/dashboard/show.php';
    }
}
