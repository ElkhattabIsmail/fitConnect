<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvel Abonnement - FitConnect</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; }
        form { max-width: 500px; margin-top: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn { padding: 10px 20px; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
        .btn-primary { background-color: #2196F3; color: white; }
        .btn-secondary { background-color: #666; color: white; }
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
    
    <h1>Nouvel Abonnement</h1>
    
    <?php if (isset($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <form method="POST" action="<?php echo $baseUrl; ?>?route=abonnements&action=create">
        <div class="form-group">
            <label for="type_abonnement">Type d'abonnement :</label>
            <select id="type_abonnement" name="type_abonnement" required>
                <option value="mensuel">Mensuel</option>
                <option value="trimestriel">Trimestriel</option>
                <option value="annuel">Annuel</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="date_debut">Date de début :</label>
            <input type="date" id="date_debut" name="date_debut" required value="<?php echo date('Y-m-d'); ?>">
        </div>
        
        <div class="form-group">
            <label for="date_fin">Date de fin :</label>
            <input type="date" id="date_fin" name="date_fin" required>
        </div>
        
        <div class="form-group">
            <label for="id_adherent">Adhérent :</label>
            <select id="id_adherent" name="id_adherent" required>
                <?php
                $adherentService = new \App\Services\AdherentService();
                $adherents = $adherentService->getAllAdherents();
                foreach ($adherents as $adherent): ?>
                    <option value="<?php echo $adherent->getIdAdherent(); ?>">
                        <?php echo htmlspecialchars($adherent->getNom() . ' ' . $adherent->getPrenom()); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Créer</button>
        <a href="<?php echo $baseUrl; ?>?route=abonnements" class="btn btn-secondary">Annuler</a>
    </form>
</body>
</html>
