<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Séance - FitConnect</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; }
        form { max-width: 500px; margin-top: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn { padding: 10px 20px; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
        .btn-primary { background-color: #9C27B0; color: white; }
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
    
    <h1>Nouvelle Séance</h1>
    
    <?php if (isset($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <form method="POST" action="<?php echo $baseUrl; ?>?route=dashboard&action=create">
        <div class="form-group">
            <label for="date_seance">Date et heure de la séance :</label>
            <input type="datetime-local" id="date_seance" name="date_seance" required>
        </div>
        
        <div class="form-group">
            <label for="duree">Durée (minutes) :</label>
            <input type="number" id="duree" name="duree" required min="1">
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
        
        <div class="form-group">
            <label for="id_salle">Salle :</label>
            <select id="id_salle" name="id_salle" required>
                <option value="1">FitConnect Paris</option>
                <option value="2">FitConnect Lyon</option>
                <option value="3">FitConnect Marseille</option>
                <option value="4">FitConnect Bordeaux</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="id_activite">Activité (optionnel) :</label>
            <select id="id_activite" name="id_activite">
                <option value="">-- Aucune --</option>
                <option value="1">Cardio</option>
                <option value="2">Musculation</option>
                <option value="3">Yoga</option>
                <option value="4">Pilates</option>
                <option value="5">CrossFit</option>
                <option value="6">Natation</option>
                <option value="7">Boxe</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="id_equipement">Équipement (optionnel) :</label>
            <select id="id_equipement" name="id_equipement">
                <option value="">-- Aucun --</option>
                <option value="1">Tapis de course</option>
                <option value="2">Vélo elliptique</option>
                <option value="3">Haltères</option>
                <option value="4">Tapis de yoga</option>
                <option value="5">Sac de frappe</option>
                <option value="6">Rameur</option>
                <option value="7">Step</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Créer</button>
        <a href="<?php echo $baseUrl; ?>?route=dashboard" class="btn btn-secondary">Annuler</a>
    </form>
</body>
</html>
