<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Adhérent - FitConnect</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; }
        form { max-width: 500px; margin-top: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn { padding: 10px 20px; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
        .btn-primary { background-color: #4CAF50; color: white; }
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
    
    <h1>Modifier Adhérent</h1>
    
    <?php if (isset($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <form method="POST" action="<?php echo $baseUrl; ?>?route=adherents&action=edit&id=<?php echo $adherent->getIdAdherent(); ?>">
        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required value="<?php echo htmlspecialchars($adherent->getNom()); ?>">
        </div>
        
        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required value="<?php echo htmlspecialchars($adherent->getPrenom()); ?>">
        </div>
        
        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($adherent->getEmail()); ?>">
        </div>
        
        <div class="form-group">
            <label for="telephone">Téléphone :</label>
            <input type="text" id="telephone" name="telephone" value="<?php echo htmlspecialchars($adherent->getTelephone() ?? ''); ?>">
        </div>
        
        <div class="form-group">
            <label for="id_salle">Salle :</label>
            <select id="id_salle" name="id_salle" required>
                <option value="1" <?php echo $adherent->getIdSalle() == 1 ? 'selected' : ''; ?>>FitConnect Paris</option>
                <option value="2" <?php echo $adherent->getIdSalle() == 2 ? 'selected' : ''; ?>>FitConnect Lyon</option>
                <option value="3" <?php echo $adherent->getIdSalle() == 3 ? 'selected' : ''; ?>>FitConnect Marseille</option>
                <option value="4" <?php echo $adherent->getIdSalle() == 4 ? 'selected' : ''; ?>>FitConnect Bordeaux</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Modifier</button>
        <a href="<?php echo $baseUrl; ?>?route=adherents" class="btn btn-secondary">Annuler</a>
    </form>
</body>
</html>
