<?php
/**
 * @var array $salles
 * @var string|null $erreur
 */
$currentPage = 'adherents';
require __DIR__ . '/../layout/header.php';
?>

<div class="topbar">
    <div>
        <h1>Nouvel adhérent</h1>
        <div class="subtitle">Inscrire un adhérent dans une salle du réseau</div>
    </div>
    <a href="index.php?page=adherents" class="btn btn-outline">← Retour à la liste</a>
</div>

<?php if ($erreur): ?>
    <div class="alert alert-error"><?= htmlspecialchars($erreur) ?></div>
<?php endif; ?>

<div class="card">
    <form method="post" action="index.php?page=adherents&action=store">
        <div class="form-grid">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="text" id="telephone" name="telephone">
            </div>
            <div class="form-group">
                <label for="date_naissance">Date de naissance</label>
                <input type="date" id="date_naissance" name="date_naissance">
            </div>
            <div class="form-group">
                <label for="id_salle">Salle d'inscription</label>
                <select id="id_salle" name="id_salle" required>
                    <option value="">— Choisir une salle —</option>
                    <?php foreach ($salles as $s): ?>
                        <option value="<?= $s['id_salle'] ?>"><?= htmlspecialchars($s['nom']) ?> (<?= htmlspecialchars($s['ville']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Inscrire l'adhérent</button>
    </form>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
