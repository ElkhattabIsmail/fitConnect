<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abonnements - FitConnect</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #2196F3; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .btn { padding: 8px 16px; text-decoration: none; border-radius: 4px; margin-right: 5px; }
        .btn-primary { background-color: #2196F3; color: white; }
        .btn-danger { background-color: #f44336; color: white; }
        .btn-warning { background-color: #ff9800; color: white; }
        .error { color: red; padding: 10px; background-color: #ffebee; margin-bottom: 10px; }
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 15px; text-decoration: none; color: #333; font-weight: bold; }
    </style>
</head>
<body>
    <div class="nav">
        <a href="<?php echo $baseUrl; ?>?route=dashboard">Dashboard</a>
        <a href="<?php echo $baseUrl; ?>?route=adherents">Adhérents</a>
        <a href="<?php echo $baseUrl; ?>?route=abonnements">Abonnements</a>
    </div>
    
    <h1>Liste des Abonnements</h1>
    
    <?php if (isset($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <a href="<?php echo $baseUrl; ?>?route=abonnements&action=create" class="btn btn-primary">Nouvel Abonnement</a>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Date Début</th>
                <th>Date Fin</th>
                <th>ID Adhérent</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($abonnements as $abonnement): ?>
                <tr>
                    <td><?php echo htmlspecialchars($abonnement->getIdAbonnement()); ?></td>
                    <td><?php echo htmlspecialchars($abonnement->getTypeAbonnement()); ?></td>
                    <td><?php echo htmlspecialchars($abonnement->getDateDebut()); ?></td>
                    <td><?php echo htmlspecialchars($abonnement->getDateFin()); ?></td>
                    <td><?php echo htmlspecialchars($abonnement->getIdAdherent()); ?></td>
                    <td>
                        <a href="<?php echo $baseUrl; ?>?route=abonnements&action=show&id=<?php echo $abonnement->getIdAbonnement(); ?>" class="btn btn-primary">Voir</a>
                        <a href="<?php echo $baseUrl; ?>?route=abonnements&action=edit&id=<?php echo $abonnement->getIdAbonnement(); ?>" class="btn btn-warning">Modifier</a>
                        <a href="<?php echo $baseUrl; ?>?route=abonnements&action=delete&id=<?php echo $abonnement->getIdAbonnement(); ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
