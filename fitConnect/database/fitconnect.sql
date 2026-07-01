-- Base de données FitConnect
-- Création de la base de données
CREATE DATABASE IF NOT EXISTS fitconnect CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE fitconnect;

-- Table SALLE
CREATE TABLE SALLE (
    id_salle INT AUTO_INCREMENT PRIMARY KEY,
    nom_salle VARCHAR(100) NOT NULL,
    adresse VARCHAR(255) NOT NULL,
    ville VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- Table ADHERENT
CREATE TABLE ADHERENT (
    id_adherent INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    telephone VARCHAR(20),
    date_inscription DATE NOT NULL,
    id_salle INT NOT NULL,
    FOREIGN KEY (id_salle) REFERENCES SALLE(id_salle)
) ENGINE=InnoDB;

-- Table ABONNEMENT
CREATE TABLE ABONNEMENT (
    id_abonnement INT AUTO_INCREMENT PRIMARY KEY,
    type_abonnement ENUM('mensuel', 'trimestriel', 'annuel') NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    id_adherent INT NOT NULL,
    FOREIGN KEY (id_adherent) REFERENCES ADHERENT(id_adherent),
    CONSTRAINT chk_dates CHECK (date_fin > date_debut)
) ENGINE=InnoDB;

-- Table TYPE_ACTIVITE
CREATE TABLE TYPE_ACTIVITE (
    id_activite INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- Table EQUIPEMENT
CREATE TABLE EQUIPEMENT (
    id_equipement INT AUTO_INCREMENT PRIMARY KEY,
    nom_equipement VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- Table SEANCE
CREATE TABLE SEANCE (
    id_seance INT AUTO_INCREMENT PRIMARY KEY,
    date_seance DATETIME NOT NULL,
    duree INT NOT NULL COMMENT 'Durée en minutes',
    id_adherent INT NOT NULL,
    id_salle INT NOT NULL,
    id_activite INT,
    id_equipement INT,
    FOREIGN KEY (id_adherent) REFERENCES ADHERENT(id_adherent),
    FOREIGN KEY (id_salle) REFERENCES SALLE(id_salle),
    FOREIGN KEY (id_activite) REFERENCES TYPE_ACTIVITE(id_activite),
    FOREIGN KEY (id_equipement) REFERENCES EQUIPEMENT(id_equipement)
) ENGINE=InnoDB;

-- Données de test pour les salles
INSERT INTO SALLE (nom_salle, adresse, ville) VALUES
('FitConnect Paris', '123 Rue de la Santé', 'Paris'),
('FitConnect Lyon', '45 Avenue Jean Jaurès', 'Lyon'),
('FitConnect Marseille', '78 Vieux Port', 'Marseille'),
('FitConnect Bordeaux', '12 Cours de l\'Intendance', 'Bordeaux');

-- Données de test pour les types d'activités
INSERT INTO TYPE_ACTIVITE (libelle) VALUES
('Cardio'),
('Musculation'),
('Yoga'),
('Pilates'),
('CrossFit'),
('Natation'),
('Boxe');

-- Données de test pour les équipements
INSERT INTO EQUIPEMENT (nom_equipement) VALUES
('Tapis de course'),
('Vélo elliptique'),
('Haltères'),
('Tapis de yoga'),
('Sac de frappe'),
('Rameur'),
('Step');

-- Données de test pour les adhérents
INSERT INTO ADHERENT (nom, prenom, email, telephone, date_inscription, id_salle) VALUES
('Dupont', 'Jean', 'jean.dupont@email.com', '0612345678', '2024-01-15', 1),
('Martin', 'Sophie', 'sophie.martin@email.com', '0623456789', '2024-02-20', 2),
('Bernard', 'Pierre', 'pierre.bernard@email.com', '0634567890', '2024-03-10', 3),
('Petit', 'Marie', 'marie.petit@email.com', '0645678901', '2024-04-05', 4);

-- Données de test pour les abonnements
INSERT INTO ABONNEMENT (type_abonnement, date_debut, date_fin, id_adherent) VALUES
('mensuel', '2024-06-01', '2024-07-01', 1),
('trimestriel', '2024-05-01', '2024-08-01', 2),
('annuel', '2024-01-01', '2025-01-01', 3),
('mensuel', '2024-06-15', '2024-07-15', 4);

-- Données de test pour les séances
INSERT INTO SEANCE (date_seance, duree, id_adherent, id_salle, id_activite, id_equipement) VALUES
('2024-06-20 09:00:00', 60, 1, 1, 1, 1),
('2024-06-21 10:30:00', 45, 2, 2, 2, 3),
('2024-06-22 14:00:00', 90, 3, 3, 5, NULL),
('2024-06-23 08:00:00', 30, 4, 4, 3, 4);
