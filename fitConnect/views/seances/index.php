<?php
/** @var array $seances (tableaux enrichis avec jointures) */
$currentPage = 'seances';
require __DIR__ . '/../layout/header.php';
?>

<div class="topbar">
    <div>
        <h1>Séances</h1>
        <div class="subtitle"><?= count($seances) ?> séance(s) enregistrée(s) récemment</div>
    </div>
    <a href="index.php?page=seances&action=create" class="btn btn-primary">+ Enregistrer une séance</a>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">Séance enregistrée avec succès.</div>
<?php endif; ?>

<?php if (empty($seances)): ?>
    <div class="card"><div class="empty-state">Aucune séance enregistrée pour le moment.</div></div>
<?php else: ?>
<table>
    <thead>
        <tr>
            <th>Adhérent</th>
            <th>Salle</th>
            <th>Activité</th>
            <th>Équipement</th>
            <th>Durée</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($seances as $s): ?>
        <tr>
            <td><?= htmlspecialchars($s['adherent_prenom'] . ' ' . $s['adherent_nom']) ?></td>
            <td><?= htmlspecialchars($s['salle_nom']) ?></td>
            <td><?= htmlspecialchars($s['activite_nom']) ?></td>
            <td><?= htmlspecialchars($s['equipement_nom'] ?? '—') ?></td>
            <td><?= (int) $s['duree_minutes'] ?> min</td>
            <td><?= htmlspecialchars($s['date_seance']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
