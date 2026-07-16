# FitConnect - Système de Gestion de Réseau de Salles de Sport

FitConnect est une application backend PHP permettant de gérer le réseau de 4 salles de sport du réseau FitConnect. L'application permet d'enregistrer les adhérents, leurs abonnements et leurs séances de sport.

## Architecture

L'application suit une architecture en couches strictement séparées :

- **Entities** (`app/Entities/`) : Classes métier représentant les entités du domaine
- **Repositories** (`app/Repositories/`) : Couche d'accès aux données avec PDO
- **Services** (`app/Services/`) : Couche métier contenant les règles de gestion
- **Controllers** (`app/Controllers/`) : Orchestration des services et repositories
- **Views** (`views/`) : Vues HTML/PHP pour l'affichage des données

## Structure du Projet

```
fitconnect/
├── config/
│   └── Database.php              # Connexion PDO singleton
├── app/
│   ├── Entities/                  # Couche métier
│   │   ├── Adherent.php
│   │   ├── Abonnement.php
│   │   └── Seance.php
│   ├── Repositories/              # Accès aux données
│   │   ├── AdherentRepository.php
│   │   ├── AbonnementRepository.php
│   │   └── SeanceRepository.php
│   ├── Services/                  # Règles métier
│   │   ├── AdherentService.php
│   │   ├── AbonnementService.php
│   │   └── SeanceService.php
│   └── Controllers/               # Orchestration
│       ├── AdherentController.php
│       ├── AbonnementController.php
│       └── SeanceController.php
├── views/                         # Vues HTML/PHP
│   ├── adherents/
│   │   ├── index.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   └── show.php
│   ├── abonnements/
│   │   ├── index.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   └── show.php
│   └── dashboard/
│       ├── index.php
│       ├── create.php
│       ├── edit.php
│       └── show.php
├── database/                      # Scripts SQL
│   ├── fitconnect_mcd.looping     # Modèle Conceptuel de Données
│   ├── fitconnect_mld.md          # Modèle Logique de Données
│   └── fitconnect.sql             # Script de création de la base
├── public/
│   ├── index.php                  # Point d'entrée unique
│   └── test.php                   # Tests des couches
├── .gitignore
└── README.md
```

## Installation

### Prérequis

- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Serveur web (Apache, Nginx, etc.)

### Configuration de la base de données

1. Importez le fichier SQL dans MySQL :
```bash
mysql -u root -p < database/fitconnect.sql
```

2. Modifiez les paramètres de connexion dans `config/Database.php` si nécessaire :
```php
private const HOST = 'localhost';
private const DB_NAME = 'fitconnect';
private const USERNAME = 'root';
private const PASSWORD = '';
```

### Configuration du serveur web

Configurez votre serveur web pour pointer vers le dossier `public/` comme document root.

Pour Apache, vous pouvez utiliser un VirtualHost :
```apache
<VirtualHost *:80>
    ServerName fitconnect.local
    DocumentRoot "C:/Users/user/Desktop/fitConnect Windsurf/public"
    
    <Directory "C:/Users/user/Desktop/fitConnect Windsurf/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

## Utilisation

### Accéder à l'application

Ouvrez votre navigateur et accédez à :
- Dashboard : `http://fitconnect.local/`
- Adhérents : `http://fitconnect.local/?route=adherents`
- Abonnements : `http://fitconnect.local/?route=abonnements`

### Tester les couches

Exécutez le fichier de test pour vérifier le bon fonctionnement de chaque couche :
```
http://fitconnect.local/test.php
```

## Règles de Gestion

- Un adhérent possède une salle d'inscription parmi les 4 salles du réseau
- Un adhérent ne détient qu'un seul abonnement actif à la fois
- Une séance ne peut être enregistrée que si l'abonnement de l'adhérent est valide
- Un adhérent ne peut pas être supprimé s'il possède des séances enregistrées ou un abonnement en cours
- Toute création, modification ou suppression respecte l'intégrité référentielle

## Entités

### Adherent
- id_adherent
- nom
- prenom
- email
- telephone
- date_inscription
- id_salle (FK)

### Abonnement
- id_abonnement
- type_abonnement (mensuel, trimestriel, annuel)
- date_debut
- date_fin
- id_adherent (FK)

### Seance
- id_seance
- date_seance
- duree (en minutes)
- id_adherent (FK)
- id_salle (FK)
- id_activite (FK, optionnel)
- id_equipement (FK, optionnel)

### Salle
- id_salle
- nom_salle
- adresse
- ville

### Type_Activite
- id_activite
- libelle

### Equipement
- id_equipement
- nom_equipement

## Développement

### Ajouter une nouvelle fonctionnalité

1. Définir l'entité dans `app/Entities/`
2. Créer le repository dans `app/Repositories/`
3. Implémenter les règles métier dans `app/Services/`
4. Créer le controller dans `app/Controllers/`
5. Ajouter les vues dans `views/`
6. Mettre à jour le routeur dans `public/index.php`