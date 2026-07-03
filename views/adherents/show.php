<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Adhérent - FitConnect</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; }
        .details { max-width: 500px; margin-top: 20px; }
        .detail-row { margin-bottom: 15px; }
        .label { font-weight: bold; color: #666; }
        .value { margin-left: 10px; }
        .btn { padding: 8px 16px; text-decoration: none; border-radius: 4px; margin-right: 5px; }
        .btn-primary { background-color: #4CAF50; color: white; }
        .btn-secondary { background-color: #666; color: white; }
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 15px; text-decoration: none; color: #333; font-weight: bold; }
        .abonnement-info { background: #e8f5e9; padding: 15px; border-radius: 4px; margin-top: 20px; }
        .no-abonnement { background: #ffebee; padding: 15px; border-radius: 4px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="nav">
        <a href="<?php echo $baseUrl; ?>?route=dashboard">Dashboard</a>
        <a href="<?php echo $baseUrl; ?>?route=adherents">Adhérents</a>
        <a href="<?php echo $baseUrl; ?>?route=abonnements">Abonnements</a>
    </div>
    
    <h1>Détails de l'Adhérent</h1>
    
    <div class="details">
        <div class="detail-row">
            <span class="label">ID :</span>
            <span class="value"><?php echo htmlspecialchars($data['adherent']->getIdAdherent()); ?></span>
        </div>
        <div class="detail-row">
            <span class="label">Nom :</span>
            <span class="value"><?php echo htmlspecialchars($data['adherent']->getNom()); ?></span>
        </div>
        <div class="detail-row">
            <span class="label">Prénom :</span>
            <span class="value"><?php echo htmlspecialchars($data['adherent']->getPrenom()); ?></span>
        </div>
        <div class="detail-row">
            <span class="label">Email :</span>
            <span class="value"><?php echo htmlspecialchars($data['adherent']->getEmail()); ?></span>
        </div>
        <div class="detail-row">
            <span class="label">Téléphone :</span>
            <span class="value"><?php echo htmlspecialchars($data['adherent']->getTelephone() ?? '-'); ?></span>
        </div>
        <div class="detail-row">
            <span class="label">Date d'inscription :</span>
            <span class="value"><?php echo htmlspecialchars($data['adherent']->getDateInscription()); ?></span>
        </div>
        <div class="detail-row">
            <span class="label">Salle :</span>
            <span class="value"><?php echo htmlspecialchars($data['adherent']->getIdSalle()); ?></span>
        </div>
    </div>
    
    <?php if ($data['active_abonnement']): ?>
        <div class="abonnement-info">
            <h3>Abonnement Actif</h3>
            <p><strong>Type :</strong> <?php echo htmlspecialchars($data['active_abonnement']->getTypeAbonnement()); ?></p>
            <p><strong>Du :</strong> <?php echo htmlspecialchars($data['active_abonnement']->getDateDebut()); ?></p>
            <p><strong>Au :</strong> <?php echo htmlspecialchars($data['active_abonnement']->getDateFin()); ?></p>
        </div>
    <?php else: ?>
        <div class="no-abonnement">
            <h3>Aucun abonnement actif</h3>
        </div>
    <?php endif; ?>
    
    <div style="margin-top: 20px;">
        <a href="<?php echo $baseUrl; ?>?route=adherents&action=edit&id=<?php echo $data['adherent']->getIdAdherent(); ?>" class="btn btn-primary">Modifier</a>
        <a href="<?php echo $baseUrl; ?>?route=adherents" class="btn btn-secondary">Retour</a>
    </div>
</body>
</html>
