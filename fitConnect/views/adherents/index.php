<?php
/**
 * @var Adherent[] $adherents
 * @var array $sallesParId
 */
$currentPage = 'adherents';
require __DIR__ . '/../layout/header.php';
?>

<div class="topbar">
    <div>
        <h1>Adhérents</h1>
        <div class="subtitle"><?= count($adherents) ?> adhérent(s) enregistré(s)</div>
    </div>
    <a href="index.php?page=adherents&action=create" class="btn btn-primary">+ Nouvel adhérent</a>
</div>

<?php if (isset($_GET['success']) && $_GET['success'] === '1'): ?>
    <div class="alert alert-success">Adhérent inscrit avec succès.</div>
<?php elseif (isset($_GET['success']) && $_GET['success'] === '2'): ?>
    <div class="alert alert-success">Adhérent supprimé avec succès.</div>
<?php elseif (isset($_GET['error'])): ?>
    <div class="alert alert-error"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

<?php if (empty($adherents)): ?>
    <div class="card"><div class="empty-state">Aucun adhérent pour le moment. Cliquez sur « Nouvel adhérent » pour commencer.</div></div>
<?php else: ?>
<table>
    <thead>
        <tr>
            <th>Nom complet</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Salle</th>
            <th>Date d'inscription</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($adherents as $a): ?>
        <tr>
            <td><?= htmlspecialchars($a->getNomComplet()) ?></td>
            <td><?= htmlspecialchars($a->getEmail()) ?></td>
            <td><?= htmlspecialchars($a->getTelephone() ?? '—') ?></td>
            <td><?= htmlspecialchars($sallesParId[$a->getIdSalle()] ?? '—') ?></td>
            <td><?= htmlspecialchars($a->getDateInscription()) ?></td>
            <td class="actions-cell">
                <form method="post" action="index.php?page=adherents&action=delete&id=<?= $a->getIdAdherent() ?>"
                      onsubmit="return confirm('Supprimer cet adhérent ?');">
                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
