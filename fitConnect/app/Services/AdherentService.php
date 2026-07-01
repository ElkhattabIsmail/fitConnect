<?php

namespace App\Services;

use App\Entities\Adherent;
use App\Repositories\AdherentRepository;
use App\Repositories\AbonnementRepository;
use App\Repositories\SeanceRepository;
use RuntimeException;

class AdherentService
{
    private AdherentRepository $adherentRepository;
    private AbonnementRepository $abonnementRepository;
    private SeanceRepository $seanceRepository;
    
    public function __construct()
    {
        $this->adherentRepository = new AdherentRepository();
        $this->abonnementRepository = new AbonnementRepository();
        $this->seanceRepository = new SeanceRepository();
    }
    
    public function getAllAdherents(): array
    {
        return $this->adherentRepository->findAll();
    }
    
    public function getAdherentById(int $id): ?Adherent
    {
        return $this->adherentRepository->findById($id);
    }
    
    public function getAdherentsBySalle(int $idSalle): array
    {
        return $this->adherentRepository->findBySalle($idSalle);
    }
    
    public function createAdherent(Adherent $adherent): Adherent
    {
        $id = $this->adherentRepository->create($adherent);
        $adherent->setIdAdherent($id);
        return $adherent;
    }
    
    public function updateAdherent(Adherent $adherent): bool
    {
        return $this->adherentRepository->update($adherent);
    }
    
    public function deleteAdherent(int $id): bool
    {
        // Vérifier si l'adhérent a des séances
        if ($this->seanceRepository->findByAdherent($id)) {
            throw new RuntimeException('Impossible de supprimer un adhérent avec des séances enregistrées');
        }
        
        // Vérifier si l'adhérent a un abonnement actif
        if ($this->adherentRepository->hasActiveAbonnement($id)) {
            throw new RuntimeException('Impossible de supprimer un adhérent avec un abonnement en cours');
        }
        
        return $this->adherentRepository->delete($id);
    }
    
    public function canDeleteAdherent(int $id): bool
    {
        return !$this->seanceRepository->findByAdherent($id) && !$this->adherentRepository->hasActiveAbonnement($id);
    }
    
    public function getAdherentWithActiveAbonnement(int $id): ?array
    {
        $adherent = $this->adherentRepository->findById($id);
        if (!$adherent) {
            return null;
        }
        
        $activeAbonnement = $this->abonnementRepository->findActiveByAdherent($id);
        
        return [
            'adherent' => $adherent,
            'active_abonnement' => $activeAbonnement
        ];
    }
}
