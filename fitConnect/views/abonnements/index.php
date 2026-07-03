<?php
/**
 * @var Abonnement[] $abonnements
 * @var array $adherentsParId
 */
$currentPage = 'abonnements';
require __DIR__ . '/../layout/header.php';

$badgeClass = [
    Abonnement::STATUT_ACTIF   => 'badge-actif',
    Abonnement::STATUT_EXPIRE  => 'badge-expire',
    Abonnement::STATUT_RESILIE => 'badge-resilie',
];
?>

<div class="topbar">
    <div>
        <h1>Abonnements</h1>
        <div class="subtitle"><?= count($abonnements) ?> abonnement(s) enregistré(s)</div>
    </div>
    <a href="index.php?page=abonnements&action=create" class="btn btn-primary">+ Nouvel abonnement</a>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">Abonnement souscrit avec succès.</div>
<?php endif; ?>

<?php if (empty($abonnements)): ?>
    <div class="card"><div class="empty-state">Aucun abonnement pour le moment.</div></div>
<?php else: ?>
<table>
    <thead>
        <tr>
            <th>Adhérent</th>
            <th>Type</th>
            <th>Début</th>
            <th>Fin</th>
            <th>Statut</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($abonnements as $ab): ?>
        <tr>
            <td><?= htmlspecialchars($adherentsParId[$ab->getIdAdherent()] ?? '—') ?></td>
            <td><?= ucfirst(htmlspecialchars($ab->getType())) ?></td>
            <td><?= htmlspecialchars($ab->getDateDebut()) ?></td>
            <td><?= htmlspecialchars($ab->getDateFin()) ?></td>
            <td><span class="badge <?= $badgeClass[$ab->getStatut()] ?? '' ?>"><?= ucfirst(htmlspecialchars($ab->getStatut())) ?></span></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
