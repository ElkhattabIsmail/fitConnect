<?php

namespace App\Services;

use App\Entities\Abonnement;
use App\Repositories\AbonnementRepository;
use App\Repositories\AdherentRepository;

class AbonnementService
{
    private AbonnementRepository $abonnementRepository;
    private AdherentRepository $adherentRepository;
    
    public function __construct()
    {
        $this->abonnementRepository = new AbonnementRepository();
        $this->adherentRepository = new AdherentRepository();
    }
    
    public function getAllAbonnements(): array
    {
        return $this->abonnementRepository->findAll();
    }
    
    public function getAbonnementById(int $id): ?Abonnement
    {
        return $this->abonnementRepository->findById($id);
    }
    
    public function getAbonnementsByAdherent(int $idAdherent): array
    {
        return $this->abonnementRepository->findByAdherent($idAdherent);
    }
    
    public function getActiveAbonnement(int $idAdherent): ?Abonnement
    {
        return $this->abonnementRepository->findActiveByAdherent($idAdherent);
    }
    
    public function createAbonnement(Abonnement $abonnement): Abonnement
    {
        // Vérifier que l'adhérent existe
        if (!$this->adherentRepository->findById($abonnement->getIdAdherent())) {
            throw new RuntimeException('Adhérent non trouvé');
        }
        
        // Vérifier les dates
        if ($abonnement->getDateFin() <= $abonnement->getDateDebut()) {
            throw new RuntimeException('La date de fin doit être postérieure à la date de début');
        }
        
        // Vérifier qu'il n'y a pas déjà un abonnement actif
        $existingActive = $this->abonnementRepository->findActiveByAdherent($abonnement->getIdAdherent());
        if ($existingActive) {
            throw new RuntimeException('L\'adhérent possède déjà un abonnement actif');
        }
        
        $id = $this->abonnementRepository->create($abonnement);
        $abonnement->setIdAbonnement($id);
        return $abonnement;
    }
    
    public function updateAbonnement(Abonnement $abonnement): bool
    {
        // Vérifier les dates
        if ($abonnement->getDateFin() <= $abonnement->getDateDebut()) {
            throw new RuntimeException('La date de fin doit être postérieure à la date de début');
        }
        
        return $this->abonnementRepository->update($abonnement);
    }
    
    public function deleteAbonnement(int $id): bool
    {
        return $this->abonnementRepository->delete($id);
    }
    
    public function isAbonnementValid(int $idAbonnement, ?string $date = null): bool
    {
        $abonnement = $this->abonnementRepository->findById($idAbonnement);
        if (!$abonnement) {
            return false;
        }

        return $abonnement->isValid($date);
    }
    
    public function hasValidAbonnement(int $idAdherent, ?string $date = null): bool
    {
        $abonnement = $this->abonnementRepository->findActiveByAdherent($idAdherent);
        if (!$abonnement) {
            return false;
        }
        
        return $abonnement->isValid($date);
    }
}
