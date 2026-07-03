<?php
/**
 * @var array $kpis
 * @var array $dernieresSeances
 */
$currentPage = 'dashboard';
require __DIR__ . '/../layout/header.php';
?>

<div class="topbar">
    <div>
        <h1>Dashboard</h1>
        <div class="subtitle">Vue d'ensemble du réseau FitConnect</div>
    </div>
</div>

<div class="grid-kpi">
    <div class="kpi-card">
        <div class="kpi-label">Adhérents</div>
        <div class="kpi-value"><?= (int) $kpis['nb_adherents'] ?></div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Abonnements actifs</div>
        <div class="kpi-value"><?= (int) $kpis['nb_abonnements_actifs'] ?></div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Séances enregistrées</div>
        <div class="kpi-value"><?= (int) $kpis['nb_seances'] ?></div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Salles du réseau</div>
        <div class="kpi-value"><?= (int) $kpis['nb_salles'] ?></div>
    </div>
</div>

<div class="card">
    <h3 style="margin-top:0;">Dernières séances enregistrées</h3>
    <?php if (empty($dernieresSeances)): ?>
        <div class="empty-state">Aucune séance enregistrée pour le moment.</div>
    <?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Adhérent</th>
                <th>Salle</th>
                <th>Activité</th>
                <th>Durée</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dernieresSeances as $s): ?>
            <tr>
                <td><?= htmlspecialchars($s['adherent_prenom'] . ' ' . $s['adherent_nom']) ?></td>
                <td><?= htmlspecialchars($s['salle_nom']) ?></td>
                <td><?= htmlspecialchars($s['activite_nom']) ?></td>
                <td><?= (int) $s['duree_minutes'] ?> min</td>
                <td><?= htmlspecialchars($s['date_seance']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
