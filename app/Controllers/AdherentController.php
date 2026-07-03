<?php

namespace App\Controllers;

use App\Services\AdherentService;
use App\Entities\Adherent;
use Exception;

class AdherentController
{
    private AdherentService $adherentService;
    private string $baseUrl;
    
    public function __construct()
    {
        $this->adherentService = new AdherentService();
        $this->baseUrl = $_SERVER['SCRIPT_NAME'];
    }
    
    public function index(): void
    {
        global $baseUrl;
        $baseUrl = $this->baseUrl;
        $adherents = $this->adherentService->getAllAdherents();
        require __DIR__ . '/../../views/adherents/index.php';
    }
    
    public function create(): void
    {
        global $baseUrl;
        $baseUrl = $this->baseUrl;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $adherent = new Adherent(
                    $_POST['nom'],
                    $_POST['prenom'],
                    $_POST['email'],
                    $_POST['date_inscription'],
                    (int) $_POST['id_salle'],
                    $_POST['telephone'] ?? null
                );
                
                $this->adherentService->createAdherent($adherent);
                header('Location: ' . $this->baseUrl . '?route=adherents');
                exit;
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        
        require __DIR__ . '/../../views/adherents/create.php';
    }
    
    public function edit(int $id): void
    {
        global $baseUrl;
        $baseUrl = $this->baseUrl;
        
        $adherent = $this->adherentService->getAdherentById($id);
        
        if (!$adherent) {
            header('Location: ' . $this->baseUrl . '?route=adherents');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $adherent->setNom($_POST['nom']);
                $adherent->setPrenom($_POST['prenom']);
                $adherent->setEmail($_POST['email']);
                $adherent->setTelephone($_POST['telephone'] ?? null);
                $adherent->setIdSalle((int) $_POST['id_salle']);
                
                $this->adherentService->updateAdherent($adherent);
                header('Location: ' . $this->baseUrl . '?route=adherents');
                exit;
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        
        require __DIR__ . '/../../views/adherents/edit.php';
    }
    
    public function delete(int $id): void
    {
        global $baseUrl;
        $baseUrl = $this->baseUrl;
        
        try {
            $this->adherentService->deleteAdherent($id);
            header('Location: ' . $this->baseUrl . '?route=adherents');
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
            $adherents = $this->adherentService->getAllAdherents();
            require __DIR__ . '/../../views/adherents/index.php';
        }
    }
    
    public function show(int $id): void
    {
        global $baseUrl;
        $baseUrl = $this->baseUrl;
        
        $data = $this->adherentService->getAdherentWithActiveAbonnement($id);
        
        if (!$data) {
            header('Location: ' . $this->baseUrl . '?route=adherents');
            exit;
        }
        
        require __DIR__ . '/../../views/adherents/show.php';
    }
}
