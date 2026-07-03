<?php

/**
 * public/test.php — teste rapidement chaque couche de l'application
 * indépendamment de l'interface utilisateur.
 *
 * Utilisation : php public/test.php   (en ligne de commande)
 *           ou : http://localhost/fitconnect/public/test.php (navigateur)
 */

declare(strict_types=1);

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

function titre(string $t): void
{
    echo "\n=== {$t} ===\n";
}

function ok(string $label, bool $condition): void
{
    echo ($condition ? '[OK]   ' : '[FAIL] ') . $label . "\n";
}

// ---- 1. Test de la connexion PDO ----
titre('Connexion base de données');
try {
    $pdo = Database::getConnection();
    ok('Connexion PDO établie', $pdo instanceof PDO);
} catch (Throwable $e) {
    ok('Connexion PDO établie', false);
    die("Erreur : " . $e->getMessage() . "\n");
}

// ---- 2. Test de la couche Entities ----
titre('Couche Entities');
try {
    $adherentTest = new Adherent(null, 'Test', 'Unitaire', 'test.unitaire@mail.com', '0600000000', '1990-01-01', date('Y-m-d'), 1);
    ok('Création entité Adherent', $adherentTest->getNomComplet() === 'Unitaire Test');

    $abonnementTest = new Abonnement(null, 'mensuel', '2026-01-01', '2026-12-31', 'actif', 1);
    ok('Abonnement valide au 2026-06-15', $abonnementTest->estValide('2026-06-15'));
    ok('Abonnement invalide au 2027-01-01', !$abonnementTest->estValide('2027-01-01'));
} catch (Throwable $e) {
    echo "Erreur couche Entities : " . $e->getMessage() . "\n";
}

// ---- 3. Test de la couche Repositories ----
titre('Couche Repositories');
$adherentRepository   = new AdherentRepository($pdo);
$abonnementRepository = new AbonnementRepository($pdo);
$seanceRepository     = new SeanceRepository($pdo);
$salleRepository      = new SalleRepository($pdo);

try {
    $salles = $salleRepository->findAll();
    ok('Lecture des 4 salles du réseau', count($salles) === 4);

    $adherents = $adherentRepository->findAll();
    ok('Lecture de la liste des adhérents (>=0)', is_array($adherents));

    $totalSeances = $seanceRepository->countTotal();
    ok('Comptage des séances', is_int($totalSeances));
} catch (Throwable $e) {
    echo "Erreur couche Repositories : " . $e->getMessage() . "\n";
}

// ---- 4. Test de la couche Services ----
titre('Couche Services (règles de gestion)');
$adherentService   = new AdherentService($adherentRepository);
$abonnementService = new AbonnementService($abonnementRepository, $adherentRepository);
$seanceService      = new SeanceService($seanceRepository, $abonnementService, $adherentRepository);

try {
    // Test : inscription d'un adhérent de test
    $emailTest = 'test.' . time() . '@fitconnect.com';
    $idNouvelAdherent = $adherentService->inscrire([
        'nom' => 'Dupont', 'prenom' => 'Jean', 'email' => $emailTest,
        'telephone' => '0600000001', 'date_naissance' => '1992-04-10',
        'date_inscription' => date('Y-m-d'), 'id_salle' => 1,
    ]);
    ok('Inscription d\'un nouvel adhérent', $idNouvelAdherent > 0);

    // Test : une séance sans abonnement actif doit être refusée (RG3)
    $seanceRefusee = false;
    try {
        $seanceService->enregistrer([
            'id_adherent' => $idNouvelAdherent, 'id_salle' => 1, 'id_activite' => 1, 'duree_minutes' => 30,
        ]);
    } catch (RuntimeException $e) {
        $seanceRefusee = true;
    }
    ok('Séance refusée sans abonnement actif (RG3)', $seanceRefusee);

    // Test : souscription d'un abonnement puis séance acceptée
    $abonnementService->souscrire([
        'id_adherent' => $idNouvelAdherent, 'type' => 'mensuel', 'date_debut' => date('Y-m-d'),
    ]);
    ok('Abonnement valide après souscription', $abonnementService->estAdherentValide($idNouvelAdherent));

    $idSeance = $seanceService->enregistrer([
        'id_adherent' => $idNouvelAdherent, 'id_salle' => 1, 'id_activite' => 1, 'duree_minutes' => 45,
    ]);
    ok('Séance acceptée avec abonnement actif', $idSeance > 0);

    // Test : suppression interdite car l'adhérent a une séance (RG5)
    $suppressionBloquee = false;
    try {
        $adherentService->supprimer($idNouvelAdherent);
    } catch (RuntimeException $e) {
        $suppressionBloquee = true;
    }
    ok('Suppression bloquée (adhérent avec séance) — RG5', $suppressionBloquee);

} catch (Throwable $e) {
    echo "Erreur couche Services : " . $e->getMessage() . "\n";
}

titre('Fin des tests');
