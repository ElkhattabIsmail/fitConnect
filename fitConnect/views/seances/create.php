<?php
/**
 * @var Adherent[] $adherents
 * @var array $salles
 * @var array $activites
 * @var string|null $erreur
 */
$currentPage = 'seances';
require __DIR__ . '/../layout/header.php';
?>

<div class="topbar">
    <div>
        <h1>Enregistrer une séance</h1>
        <div class="subtitle">La séance ne sera enregistrée que si l'abonnement de l'adhérent est valide aujourd'hui</div>
    </div>
    <a href="index.php?page=seances" class="btn btn-outline">← Retour à la liste</a>
</div>

<?php if ($erreur): ?>
    <div class="alert alert-error"><?= htmlspecialchars($erreur) ?></div>
<?php endif; ?>

<div class="card">
    <form method="post" action="index.php?page=seances&action=store">
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
                <label for="id_salle">Salle</label>
                <select id="id_salle" name="id_salle" required>
                    <option value="">— Choisir une salle —</option>
                    <?php foreach ($salles as $s): ?>
                        <option value="<?= $s['id_salle'] ?>"><?= htmlspecialchars($s['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_activite">Activité</label>
                <select id="id_activite" name="id_activite" required>
                    <option value="">— Choisir une activité —</option>
                    <?php foreach ($activites as $act): ?>
                        <option value="<?= $act['id_activite'] ?>"><?= htmlspecialchars($act['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="duree_minutes">Durée (minutes)</label>
                <input type="number" id="duree_minutes" name="duree_minutes" min="1" required>
            </div>
            <div class="form-group">
                <label for="id_equipement">Équipement utilisé (optionnel — ID)</label>
                <input type="number" id="id_equipement" name="id_equipement" min="1" placeholder="Laisser vide si aucun">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer la séance</button>
    </form>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
