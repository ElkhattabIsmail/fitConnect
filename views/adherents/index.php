<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adhérents - FitConnect</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .btn { padding: 8px 16px; text-decoration: none; border-radius: 4px; margin-right: 5px; }
        .btn-primary { background-color: #4CAF50; color: white; }
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
    
    <h1>Liste des Adhérents</h1>
    
    <?php if (isset($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <a href="<?php echo $baseUrl; ?>?route=adherents&action=create" class="btn btn-primary">Nouvel Adhérent</a>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Date Inscription</th>
                <th>Salle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($adherents as $adherent): ?>
                <tr>
                    <td><?php echo htmlspecialchars($adherent->getIdAdherent()); ?></td>
                    <td><?php echo htmlspecialchars($adherent->getNom()); ?></td>
                    <td><?php echo htmlspecialchars($adherent->getPrenom()); ?></td>
                    <td><?php echo htmlspecialchars($adherent->getEmail()); ?></td>
                    <td><?php echo htmlspecialchars($adherent->getTelephone() ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($adherent->getDateInscription()); ?></td>
                    <td><?php echo htmlspecialchars($adherent->getIdSalle()); ?></td>
                    <td>
                        <a href="<?php echo $baseUrl; ?>?route=adherents&action=show&id=<?php echo $adherent->getIdAdherent(); ?>" class="btn btn-primary">Voir</a>
                        <a href="<?php echo $baseUrl; ?>?route=adherents&action=edit&id=<?php echo $adherent->getIdAdherent(); ?>" class="btn btn-warning">Modifier</a>
                        <a href="<?php echo $baseUrl; ?>?route=adherents&action=delete&id=<?php echo $adherent->getIdAdherent(); ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
