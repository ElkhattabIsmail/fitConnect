<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FitConnect</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #9C27B0; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .btn { padding: 8px 16px; text-decoration: none; border-radius: 4px; margin-right: 5px; }
        .btn-primary { background-color: #9C27B0; color: white; }
        .btn-danger { background-color: #f44336; color: white; }
        .btn-warning { background-color: #ff9800; color: white; }
        .error { color: red; padding: 10px; background-color: #ffebee; margin-bottom: 10px; }
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 15px; text-decoration: none; color: #333; font-weight: bold; }
        .stats { display: flex; gap: 20px; margin-bottom: 20px; }
        .stat-card { background: #f5f5f5; padding: 20px; border-radius: 8px; min-width: 200px; }
        .stat-card h3 { margin: 0 0 10px 0; color: #666; }
        .stat-card .value { font-size: 2em; font-weight: bold; color: #9C27B0; }
    </style>
</head>
<body>
    <div class="nav">
        <a href="<?php echo $baseUrl; ?>?route=dashboard">Dashboard</a>
        <a href="<?php echo $baseUrl; ?>?route=adherents">Adhérents</a>
        <a href="<?php echo $baseUrl; ?>?route=abonnements">Abonnements</a>
    </div>
    
    <h1>Dashboard - Séances</h1>
    
    <?php if (isset($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <?php
    $seanceService = new \App\Services\SeanceService();
    $adherentService = new \App\Services\AdherentService();
    
    
    $stats = $seanceService->getSeanceStats();
    ?>
    
    <div class="stats">
        <div class="stat-card">
            <h3>Total Séances</h3>
            <div class="value"><?php echo $stats['total_seances']; ?></div>
        </div>
        <div class="stat-card">
            <h3>Durée Totale (min)</h3>
            <div class="value"><?php echo $stats['total_duree']; ?></div>
        </div>
    </div>
    
    <a href="<?php echo $baseUrl; ?>?route=dashboard&action=create" class="btn btn-primary">Nouvelle Séance</a>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Durée (min)</th>
                <th>Adhérent (Nom Prénom)</th>
                <th>ID Salle</th>
                <th>Activité</th>
                <th>Équipement</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($seances as $seance): ?>
                <tr>
                    <td><?php echo htmlspecialchars($seance->getIdSeance()); ?></td>
                    <td><?php echo htmlspecialchars($seance->getDateSeance()); ?></td>
                    <td><?php echo htmlspecialchars($seance->getDuree()); ?></td>
                    <td><?php echo htmlspecialchars( $adherentService->getAdherentById($seance->getIdAdherent())?->getNom() . ' ' . $adherentService->getAdherentById($seance->getIdAdherent())?->getPrenom() ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($seance->getNomSalle() ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($seance->getActiviteLibelle() ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($seance->getNomEquipement() ?? '-'); ?></td>
                    <td>
                        <a href="<?php echo $baseUrl; ?>?route=dashboard&action=show&id=<?php echo $seance->getIdSeance(); ?>" class="btn btn-primary">Voir</a>
                        <a href="<?php echo $baseUrl; ?>?route=dashboard&action=edit&id=<?php echo $seance->getIdSeance(); ?>" class="btn btn-warning">Modifier</a>
                        <a href="<?php echo $baseUrl; ?>?route=dashboard&action=delete&id=<?php echo $seance->getIdSeance(); ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
-