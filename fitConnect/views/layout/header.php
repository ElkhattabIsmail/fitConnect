<?php
// $currentPage doit être défini par la vue qui inclut ce header (adherents, abonnements, seances, dashboard)
$currentPage = $currentPage ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitConnect — Gestion du réseau</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <div class="brand">
            <span class="logo-dot"></span>
            <span>FitConnect</span>
        </div>
        <nav>
            <a href="index.php?page=dashboard" class="<?= $currentPage === 'dashboard' ? 'active' : '' ?>">📊 Dashboard</a>
            <a href="index.php?page=adherents" class="<?= $currentPage === 'adherents' ? 'active' : '' ?>">👤 Adhérents</a>
            <a href="index.php?page=abonnements" class="<?= $currentPage === 'abonnements' ? 'active' : '' ?>">💳 Abonnements</a>
            <a href="index.php?page=seances" class="<?= $currentPage === 'seances' ? 'active' : '' ?>">🏋️ Séances</a>
        </nav>
    </aside>
    <main class="main">
