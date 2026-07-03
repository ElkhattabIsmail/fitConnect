<?php
/**
 * @var Adherent[] $adherents
 * @var string|null $erreur
 */
$currentPage = 'abonnements';
require __DIR__ . '/../layout/header.php';
?>

<div class="topbar">
    <div>
        <h1>Nouvel abonnement</h1>
        <div class="subtitle">Souscrire un abonnement pour un adhérent (résilie automatiquement l'ancien abonnement actif)</div>
    </div>
    <a href="index.php?page=abonnements" class="btn btn-outline">← Retour à la liste</a>
</div>

<?php if ($erreur): ?>
    <div class="alert alert-error"><?= htmlspecialchars($erreur) ?></div>
<?php endif; ?>

<div class="card">
    <form method="post" action="index.php?page=abonnements&action=store">
        <div class="form-grid">
            <div class="form-group full">
                <label for="id_adherent">Adhérent</label>
                <select id="id_adherent" name="id_adherent" required>
                    <option value="">— Choisir un adhérent —</option>
                    <?php foreach ($adherents as $a): ?>
                        <option value="<?= $a->getIdAdherent() ?>"><?= htmlspecialchars($a->getNomComplet()) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="type">Type d'abonnement</label>
                <select id="type" name="type" required>
                    <option value="mensuel">Mensuel (30 jours)</option>
                    <option value="trimestriel">Trimestriel (90 jours)</option>
                    <option value="annuel">Annuel (365 jours)</option>
                </select>
            </div>
            <div class="form-group">
                <label for="date_debut">Date de début</label>
                <input type="date" id="date_debut" name="date_debut" value="<?= date('Y-m-d') ?>" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Souscrire l'abonnement</button>
    </form>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
