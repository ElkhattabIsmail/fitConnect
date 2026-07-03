<?php

require_once __DIR__ . '/../config/Database.php';

spl_autoload_register(function ($class) {
    $file = __DIR__ . '/../app/' . str_replace(['App\\', '\\'], ['', '/'], $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

echo "<h1>FitConnect - Tests des couches</h1>";
echo "<hr>";

// Test 1: Connexion à la base de données
echo "<h2>Test 1: Connexion à la base de données</h2>";
try {
    $db = \Config\Database::getConnection();
    echo "<p style='color: green;'>✓ Connexion réussie</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Erreur de connexion: " . $e->getMessage() . "</p>";
}

// Test 2: Création d'une entité Adherent
echo "<h2>Test 2: Création d'une entité Adherent</h2>";
try {
    $adherent = new \App\Entities\Adherent(
        'Test',
        'Utilisateur',
        'test@example.com',
        date('Y-m-d'),
        1,
        '0612345678'
    );
    echo "<p style='color: green;'>✓ Entité Adherent créée: " . $adherent->getNom() . " " . $adherent->getPrenom() . "</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Erreur: " . $e->getMessage() . "</p>";
}

// Test 3: Création d'une entité Abonnement
echo "<h2>Test 3: Création d'une entité Abonnement</h2>";
try {
    $abonnement = new \App\Entities\Abonnement(
        'mensuel',
        '2024-06-01',
        '2024-07-01',
        1
    );
    echo "<p style='color: green;'>✓ Entité Abonnement créée: " . $abonnement->getTypeAbonnement() . "</p>";
    echo "<p>Validité: " . ($abonnement->isValid() ? 'Valide' : 'Expiré') . "</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Erreur: " . $e->getMessage() . "</p>";
}

// Test 4: Création d'une entité Seance
echo "<h2>Test 4: Création d'une entité Seance</h2>";
try {
    $seance = new \App\Entities\Seance(
        '2024-06-20 10:00:00',
        60,
        1,
        1,
        1,
        1
    );
    echo "<p style='color: green;'>✓ Entité Seance créée: Durée " . $seance->getDuree() . " minutes</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Erreur: " . $e->getMessage() . "</p>";
}

// Test 5: Repository - Récupérer tous les adhérents
echo "<h2>Test 5: Repository - Récupérer tous les adhérents</h2>";
try {
    $adherentRepo = new \App\Repositories\AdherentRepository();
    $adherents = $adherentRepo->findAll();
    echo "<p style='color: green;'>✓ " . count($adherents) . " adhérent(s) trouvé(s)</p>";
    foreach ($adherents as $adh) {
        echo "<p>- " . $adh->getNom() . " " . $adh->getPrenom() . " (" . $adh->getEmail() . ")</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Erreur: " . $e->getMessage() . "</p>";
}

// Test 6: Repository - Récupérer tous les abonnements
echo "<h2>Test 6: Repository - Récupérer tous les abonnements</h2>";
try {
    $abonnementRepo = new \App\Repositories\AbonnementRepository();
    $abonnements = $abonnementRepo->findAll();
    echo "<p style='color: green;'>✓ " . count($abonnements) . " abonnement(s) trouvé(s)</p>";
    foreach ($abonnements as $abo) {
        echo "<p>- " . $abo->getTypeAbonnement() . " (Adhérent ID: " . $abo->getIdAdherent() . ")</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Erreur: " . $e->getMessage() . "</p>";
}

// Test 7: Repository - Récupérer toutes les séances
echo "<h2>Test 7: Repository - Récupérer toutes les séances</h2>";
try {
    $seanceRepo = new \App\Repositories\SeanceRepository();
    $seances = $seanceRepo->findAll();
    echo "<p style='color: green;'>✓ " . count($seances) . " séance(s) trouvée(s)</p>";
    foreach ($seances as $sea) {
        echo "<p>- " . $sea->getDateSeance() . " (" . $sea->getDuree() . " min)</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Erreur: " . $e->getMessage() . "</p>";
}

// Test 8: Service - Vérifier la validité d'un abonnement
echo "<h2>Test 8: Service - Vérifier la validité d'un abonnement</h2>";
try {
    $abonnementService = new \App\Services\AbonnementService();
    $abonnements = $abonnementService->getAllAbonnements();
    if (!empty($abonnements)) {
        $firstAbonnement = $abonnements[0];
        $isValid = $abonnementService->isAbonnementValid($firstAbonnement->getIdAbonnement());
        echo "<p style='color: green;'>✓ Abonnement ID " . $firstAbonnement->getIdAbonnement() . ": " . ($isValid ? 'Valide' : 'Expiré') . "</p>";
    } else {
        echo "<p style='color: orange;'>⚠ Aucun abonnement trouvé</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Erreur: " . $e->getMessage() . "</p>";
}

// Test 9: Service - Statistiques des séances
echo "<h2>Test 9: Service - Statistiques des séances</h2>";
try {
    $seanceService = new \App\Services\SeanceService();
    $stats = $seanceService->getSeanceStats();
    echo "<p style='color: green;'>✓ Statistiques récupérées</p>";
    echo "<p>- Total séances: " . $stats['total_seances'] . "</p>";
    echo "<p>- Durée totale: " . $stats['total_duree'] . " minutes</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Erreur: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h2>Tests terminés</h2>";
