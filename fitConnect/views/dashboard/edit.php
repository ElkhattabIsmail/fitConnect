<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Séance - FitConnect</title>
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
    
    <h1>Modifier Séance</h1>
    
    <?php if (isset($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <form method="POST" action="<?php echo $baseUrl; ?>?route=dashboard&action=edit&id=<?php echo $seance->getIdSeance(); ?>">
        <div class="form-group">
            <label for="date_seance">Date et heure de la séance :</label>
            <input type="datetime-local" id="date_seance" name="date_seance" required value="<?php echo htmlspecialchars($seance->getDateSeance()); ?>">
        </div>
        
        <div class="form-group">
            <label for="duree">Durée (minutes) :</label>
            <input type="number" id="duree" name="duree" required min="1" value="<?php echo htmlspecialchars($seance->getDuree()); ?>">
        </div>
        
        <div class="form-group">
            <label for="id_adherent">Adhérent :</label>
            <select id="id_adherent" name="id_adherent" required>
                <?php
                $adherentService = new \App\Services\AdherentService();
                $adherents = $adherentService->getAllAdherents();
                foreach ($adherents as $adherent): ?>
                    <option value="<?php echo $adherent->getIdAdherent(); ?>" <?php echo $seance->getIdAdherent() == $adherent->getIdAdherent() ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($adherent->getNom() . ' ' . $adherent->getPrenom()); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="id_salle">Salle :</label>
            <select id="id_salle" name="id_salle" required>
                <option value="1" <?php echo $seance->getIdSalle() == 1 ? 'selected' : ''; ?>>FitConnect Paris</option>
                <option value="2" <?php echo $seance->getIdSalle() == 2 ? 'selected' : ''; ?>>FitConnect Lyon</option>
                <option value="3" <?php echo $seance->getIdSalle() == 3 ? 'selected' : ''; ?>>FitConnect Marseille</option>
                <option value="4" <?php echo $seance->getIdSalle() == 4 ? 'selected' : ''; ?>>FitConnect Bordeaux</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="id_activite">Activité (optionnel) :</label>
            <select id="id_activite" name="id_activite">
                <option value="">-- Aucune --</option>
                <option value="1" <?php echo $seance->getIdActivite() == 1 ? 'selected' : ''; ?>>Cardio</option>
                <option value="2" <?php echo $seance->getIdActivite() == 2 ? 'selected' : ''; ?>>Musculation</option>
                <option value="3" <?php echo $seance->getIdActivite() == 3 ? 'selected' : ''; ?>>Yoga</option>
                <option value="4" <?php echo $seance->getIdActivite() == 4 ? 'selected' : ''; ?>>Pilates</option>
                <option value="5" <?php echo $seance->getIdActivite() == 5 ? 'selected' : ''; ?>>CrossFit</option>
                <option value="6" <?php echo $seance->getIdActivite() == 6 ? 'selected' : ''; ?>>Natation</option>
                <option value="7" <?php echo $seance->getIdActivite() == 7 ? 'selected' : ''; ?>>Boxe</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="id_equipement">Équipement (optionnel) :</label>
            <select id="id_equipement" name="id_equipement">
                <option value="">-- Aucun --</option>
                <option value="1" <?php echo $seance->getIdEquipement() == 1 ? 'selected' : ''; ?>>Tapis de course</option>
                <option value="2" <?php echo $seance->getIdEquipement() == 2 ? 'selected' : ''; ?>>Vélo elliptique</option>
                <option value="3" <?php echo $seance->getIdEquipement() == 3 ? 'selected' : ''; ?>>Haltères</option>
                <option value="4" <?php echo $seance->getIdEquipement() == 4 ? 'selected' : ''; ?>>Tapis de yoga</option>
                <option value="5" <?php echo $seance->getIdEquipement() == 5 ? 'selected' : ''; ?>>Sac de frappe</option>
                <option value="6" <?php echo $seance->getIdEquipement() == 6 ? 'selected' : ''; ?>>Rameur</option>
                <option value="7" <?php echo $seance->getIdEquipement() == 7 ? 'selected' : ''; ?>>Step</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Modifier</button>
        <a href="<?php echo $baseUrl; ?>?route=dashboard" class="btn btn-secondary">Annuler</a>
    </form>
</body>
</html>
