<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Abonnement - FitConnect</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; }
        .details { max-width: 500px; margin-top: 20px; }
        .detail-row { margin-bottom: 15px; }
        .label { font-weight: bold; color: #666; }
        .value { margin-left: 10px; }
        .btn { padding: 8px 16px; text-decoration: none; border-radius: 4px; margin-right: 5px; }
        .btn-primary { background-color: #2196F3; color: white; }
        .btn-secondary { background-color: #666; color: white; }
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
    
    <h1>Détails de l'Abonnement</h1>
    
    <div class="details">
        <div class="detail-row">
            <span class="label">ID :</span>
            <span class="value"><?php echo htmlspecialchars($abonnement->getIdAbonnement()); ?></span>
        </div>
        <div class="detail-row">
            <span class="label">Type :</span>
            <span class="value"><?php echo htmlspecialchars($abonnement->getTypeAbonnement()); ?></span>
        </div>
        <div class="detail-row">
            <span class="label">Date de début :</span>
            <span class="value"><?php echo htmlspecialchars($abonnement->getDateDebut()); ?></span>
        </div>
        <div class="detail-row">
            <span class="label">Date de fin :</span>
            <span class="value"><?php echo htmlspecialchars($abonnement->getDateFin()); ?></span>
        </div>
        <div class="detail-row">
            <span class="label">ID Adhérent :</span>
            <span class="value"><?php echo htmlspecialchars($abonnement->getIdAdherent()); ?></span>
        </div>
        <div class="detail-row">
            <span class="label">Statut :</span>
            <span class="value"><?php echo $abonnement->isValid() ? '<span style="color: green;">Actif</span>' : '<span style="color: red;">Expiré</span>'; ?></span>
        </div>
    </div>
    
    <div style="margin-top: 20px;">
        <a href="<?php echo $baseUrl; ?>?route=abonnements&action=edit&id=<?php echo $abonnement->getIdAbonnement(); ?>" class="btn btn-primary">Modifier</a>
        <a href="<?php echo $baseUrl; ?>?route=abonnements" class="btn btn-secondary">Retour</a>
    </div>
</body>
</html>
