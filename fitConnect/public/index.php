<?php

/**
 * public/index.php — point d'entrée unique de l'application FitConnect.
 * Routeur simple basé sur ?page=...&action=...
 */

declare(strict_types=1);

// ---- Autoload manuel des classes (Entities, Repositories, Services, Controllers) ----
spl_autoload_register(function (string $class): void {
    $dirs = [
        __DIR__ . '/../config/',
        __DIR__ . '/../app/Entities/',
        __DIR__ . '/../app/Repositories/',
        __DIR__ . '/../app/Services/',
        __DIR__ . '/../app/Controllers/',
    ];
    foreach ($dirs as $dir) {
        $file = $dir . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

try {
    $pdo = Database::getConnection();
} catch (Throwable $e) {
    http_response_code(500);
    die('<h2>Erreur de connexion à la base de données</h2><p>' . htmlspecialchars($e->getMessage()) . '</p>');
}

// ---- Injection des dépendances (Repositories -> Services -> Controllers) ----
$adherentRepository    = new AdherentRepository($pdo);
$abonnementRepository  = new AbonnementRepository($pdo);
$seanceRepository      = new SeanceRepository($pdo);
$salleRepository       = new SalleRepository($pdo);
$referentielRepository = new ReferentielRepository($pdo);

$adherentService   = new AdherentService($adherentRepository);
$abonnementService = new AbonnementService($abonnementRepository, $adherentRepository);
$seanceService      = new SeanceService($seanceRepository, $abonnementService, $adherentRepository);

$adherentController   = new AdherentController($adherentService, $salleRepository);
$abonnementController = new AbonnementController($abonnementService, $adherentService);
$seanceController      = new SeanceController($seanceService, $adherentService, $salleRepository, $referentielRepository);

// ---- Routage ----
$page   = $_GET['page'] ?? 'dashboard';
$action = $_GET['action'] ?? 'index';

switch ($page) {

    case 'adherents':
        match ($action) {
            'create' => $adherentController->create(),
            'store'  => $adherentController->store(),
            'delete' => $adherentController->delete((int) ($_GET['id'] ?? 0)),
            default  => $adherentController->index(),
        };
        break;

    case 'abonnements':
        match ($action) {
            'create' => $abonnementController->create(),
            'store'  => $abonnementController->store(),
            default  => $abonnementController->index(),
        };
        break;

    case 'seances':
        match ($action) {
            'create' => $seanceController->create(),
            'store'  => $seanceController->store(),
            default  => $seanceController->index(),
        };
        break;

    case 'dashboard':
    default:
        $kpis = [
            'nb_adherents'           => count($adherentService->listerTous()),
            'nb_abonnements_actifs'  => count(array_filter(
                $abonnementService->listerTous(),
                fn($a) => $a->getStatut() === Abonnement::STATUT_ACTIF
            )),
            'nb_seances'             => $seanceService->statistiquesGlobales()['total_seances'],
            'nb_salles'              => count($salleRepository->findAll()),
        ];
        $dernieresSeances = $seanceService->listerToutes(10);
        require __DIR__ . '/../views/dashboard/index.php';
        break;
}
