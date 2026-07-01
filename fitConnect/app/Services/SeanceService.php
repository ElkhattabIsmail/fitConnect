<?php

namespace App\Services;

use App\Entities\Seance;
use App\Repositories\SeanceRepository;
use App\Repositories\AbonnementRepository;
use App\Repositories\AdherentRepository;

class SeanceService
{
    private SeanceRepository $seanceRepository;
    private AbonnementRepository $abonnementRepository;
    private AdherentRepository $adherentRepository;
    
    public function __construct()
    {
        $this->seanceRepository = new SeanceRepository();
        $this->abonnementRepository = new AbonnementRepository();
        $this->adherentRepository = new AdherentRepository();
    }
    
    public function getAllSeances(): array
    {
        return $this->seanceRepository->findAll();
    }
    
    public function getSeanceById(int $id): ?Seance
    {
        return $this->seanceRepository->findById($id);
    }
    
    public function getSeancesByAdherent(int $idAdherent): array
    {
        return $this->seanceRepository->findByAdherent($idAdherent);
    }
    
    public function getSeancesBySalle(int $idSalle): array
    {
        return $this->seanceRepository->findBySalle($idSalle);
    }
    
    public function createSeance(Seance $seance): Seance
    {
        // Vérifier que l'adhérent existe
        if (!$this->adherentRepository->findById($seance->getIdAdherent())) {
            throw new RuntimeException('Adhérent non trouvé');
        }
        
        // Vérifier que l'adhérent a un abonnement valide à la date de la séance
        $seanceDate = substr($seance->getDateSeance(), 0, 10); // Extraire la date YYYY-MM-DD
        if (!$this->abonnementRepository->findActiveByAdherent($seance->getIdAdherent())) {
            throw new RuntimeException('L\'adhérent n\'a pas d\'abonnement actif');
        }
        
        $activeAbonnement = $this->abonnementRepository->findActiveByAdherent($seance->getIdAdherent());
        if (!$activeAbonnement->isValid($seanceDate)) {
            throw new RuntimeException('L\'abonnement n\'est pas valide à la date de la séance');
        }
        
        $id = $this->seanceRepository->create($seance);
        $seance->setIdSeance($id);
        return $seance;
    }
    
    public function updateSeance(Seance $seance): bool
    {
        return $this->seanceRepository->update($seance);
    }
    
    public function deleteSeance(int $id): bool
    {
        return $this->seanceRepository->delete($id);
    }
    
    public function getSeanceStats(): array
    {
        $seances = $this->seanceRepository->findAll();
        
        $totalSeances = count($seances);
        $totalDuree = 0;
        $seancesByAdherent = [];
        $seancesBySalle = [];
        
        foreach ($seances as $seance) {
            $totalDuree += $seance->getDuree();
            
            $idAdherent = $seance->getIdAdherent();
            if (!isset($seancesByAdherent[$idAdherent])) {
                $seancesByAdherent[$idAdherent] = 0;
            }
            $seancesByAdherent[$idAdherent]++;
            
            $idSalle = $seance->getIdSalle();
            if (!isset($seancesBySalle[$idSalle])) {
                $seancesBySalle[$idSalle] = 0;
            }
            $seancesBySalle[$idSalle]++;
        }
        
        return [
            'total_seances' => $totalSeances,
            'total_duree' => $totalDuree,
            'seances_by_adherent' => $seancesByAdherent,
            'seances_by_salle' => $seancesBySalle
        ];
    }
}
