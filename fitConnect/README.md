# FitConnect — Backend PHP OOP (PDO + MySQL)

Application backend pour la gestion du réseau de salles de sport FitConnect
(adhérents, abonnements, activités, équipements), développée en PHP orienté
objet avec une architecture en couches et une connexion PDO sécurisée.

## Architecture

```
fitconnect/
├── config/
│   └── Database.php          # Connexion PDO centralisée (Singleton)
├── app/
│   ├── Entities/              # Adherent, Abonnement, Seance (encapsulation stricte)
│   ├── Repositories/          # Accès aux données — requêtes PDO paramétrées uniquement
│   ├── Services/               # Logique métier (règles de gestion), indépendante des Repositories
│   └── Controllers/           # Orchestration Services + Repositories -> Vues
├── views/                      # Vues HTML/PHP (adherents, abonnements, seances, dashboard)
├── database/
│   ├── MCD-MLD.md              # Conception Merise (MCD + MLD + normalisation)
│   ├── schema.sql               # Script de création de la base (à partir du MLD)
│   └── seed.sql                 # Jeu de données de test
└── public/
    ├── index.php                # Point d'entrée unique (routeur)
    ├── test.php                  # Tests manuels des couches (Entities/Repositories/Services)
    └── assets/css/style.css      # Design violet / noir
```

## Installation

1. Créer la base de données :
   ```bash
   mysql -u root -p < database/schema.sql
   mysql -u root -p < database/seed.sql
   ```
2. Configurer les identifiants de connexion dans `config/Database.php`
   (variables `$host`, `$dbname`, `$user`, `$pass`).
3. Servir le dossier `public/` avec un serveur PHP :
   ```bash
   php -S localhost:8000 -t public
   ```
4. Ouvrir `http://localhost:8000` dans le navigateur.

## Tester les couches indépendamment de l'UI

```bash
php public/test.php
```
Ce script vérifie : la connexion PDO, les entités (validation métier), les
repositories (lecture des données), et les services (règles de gestion RG1 à RG5).

## Règles de gestion appliquées

- **RG1** — Un adhérent appartient à une seule salle d'inscription.
- **RG2** — Un adhérent ne détient qu'un seul abonnement actif à la fois
  (`AbonnementService::souscrire` résilie automatiquement l'ancien abonnement actif).
- **RG3** — Une séance n'est enregistrée que si l'abonnement de l'adhérent est
  valide à la date du jour (`SeanceService::enregistrer`).
- **RG4** — Une séance référence obligatoirement adhérent, salle, activité ;
  l'équipement est optionnel.
- **RG5** — Un adhérent avec des séances enregistrées ou un abonnement en cours
  ne peut pas être supprimé (`AdherentService::supprimer`).

Toutes les requêtes SQL sont exclusivement paramétrées (PDO prepared statements)
afin de prévenir les injections SQL.

## Stack technique

- PHP 8.1+ (types stricts, `match`, propriétés typées)
- MySQL / MariaDB (InnoDB, contraintes de clés étrangères)
- PDO (`PDO::ATTR_EMULATE_PREPARES => false`)
- Aucune dépendance externe (pas de framework, pas de Composer requis)

## Auteur

Projet réalisé dans le cadre du parcours Développeur Web et Web Mobile — DevAcademy.
