<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Séance - FitConnect</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; }
        .details { max-width: 500px; margin-top: 20px; }
        .detail-row { margin-bottom: 15px; }
        .label { font-weight: bold; color: #666; }
        .value { margin-left: 10px; }
        .btn { padding: 8px 16px; text-decoration: none; border-radius: 4px; margin-right: 5px; }
        .btn-primary { background-color: #9C27B0; color: white; }
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
    
    <h1>Détails de la Séance</h1>
    
    <div class="details">
        <div class="detail-row">
            <span class="label">ID :</span>
            <span class="value"><?php echo htmlspecialchars($seance->getIdSeance()); ?></span>
        </div>
        <div class="detail-row">
            <span class="label">Date et heure :</span>
            <span class="value"><?php echo htmlspecialchars($seance->getDateSeance()); ?></span>
        </div>
        <div class="detail-row">
            <span class="label">Durée :</span>
            <span class="value"><?php echo htmlspecialchars($seance->getDuree()); ?> minutes</span>
        </div>
        <div class="detail-row">
            <span class="label">ID Adhérent :</span>
            <span class="value"><?php echo htmlspecialchars($seance->getIdAdherent()); ?></span>
        </div>
        <div class="detail-row">
            <span class="label">ID Salle :</span>
            <span class="value"><?php echo htmlspecialchars($seance->getIdSalle()); ?></span>
        </div>
        <div class="detail-row">
            <span class="label">Activité :</span>
            <span class="value"><?php echo htmlspecialchars($seance->getIdActivite() ?? '-'); ?></span>
        </div>
        <div class="detail-row">
            <span class="label">Équipement :</span>
            <span class="value"><?php echo htmlspecialchars($seance->getIdEquipement() ?? '-'); ?></span>
        </div>
    </div>
    
    <div style="margin-top: 20px;">
        <a href="<?php echo $baseUrl; ?>?route=dashboard&action=edit&id=<?php echo $seance->getIdSeance(); ?>" class="btn btn-primary">Modifier</a>
        <a href="<?php echo $baseUrl; ?>?route=dashboard" class="btn btn-secondary">Retour</a>
    </div>
</body>
</html>
