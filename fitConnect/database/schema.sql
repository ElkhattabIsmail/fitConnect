-- =====================================================================
-- FitConnect - Script de création de la base de données
-- Réalisé strictement à partir du MLD validé (voir README.md / MCD-MLD.md)
-- Moteur : InnoDB (obligatoire pour le respect des clés étrangères)
-- =====================================================================

DROP DATABASE IF EXISTS fitconnect;
CREATE DATABASE fitconnect CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE fitconnect;

-- ---------------------------------------------------------------------
-- Table : salles
-- Les 4 salles du réseau FitConnect
-- ---------------------------------------------------------------------
CREATE TABLE salles (
    id_salle      INT AUTO_INCREMENT PRIMARY KEY,
    nom           VARCHAR(100) NOT NULL,
    adresse       VARCHAR(255) NOT NULL,
    ville         VARCHAR(100) NOT NULL,
    telephone     VARCHAR(20)  NULL
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Table : adherents
-- Un adhérent est rattaché à une salle d'inscription (1,1)-(0,n)
-- ---------------------------------------------------------------------
CREATE TABLE adherents (
    id_adherent     INT AUTO_INCREMENT PRIMARY KEY,
    nom             VARCHAR(100) NOT NULL,
    prenom          VARCHAR(100) NOT NULL,
    email           VARCHAR(150) NOT NULL UNIQUE,
    telephone       VARCHAR(20)  NULL,
    date_naissance  DATE         NULL,
    date_inscription DATE        NOT NULL DEFAULT (CURRENT_DATE),
    id_salle        INT          NOT NULL,
    CONSTRAINT fk_adherent_salle
        FOREIGN KEY (id_salle) REFERENCES salles(id_salle)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Table : abonnements
-- Un adhérent ne détient qu'un seul abonnement ACTIF à la fois.
-- Cette règle est appliquée par la couche Service (AbonnementService)
-- avant toute insertion, en plus de l'intégrité référentielle ici.
-- ---------------------------------------------------------------------
CREATE TABLE abonnements (
    id_abonnement   INT AUTO_INCREMENT PRIMARY KEY,
    type            ENUM('mensuel', 'trimestriel', 'annuel') NOT NULL,
    date_debut      DATE NOT NULL,
    date_fin        DATE NOT NULL,
    statut          ENUM('actif', 'expire', 'resilie') NOT NULL DEFAULT 'actif',
    id_adherent     INT NOT NULL,
    CONSTRAINT fk_abonnement_adherent
        FOREIGN KEY (id_adherent) REFERENCES adherents(id_adherent)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT chk_dates_abonnement CHECK (date_fin > date_debut)
) ENGINE=InnoDB;

CREATE INDEX idx_abonnement_adherent_statut ON abonnements(id_adherent, statut);

-- ---------------------------------------------------------------------
-- Table : types_activite
-- Référentiel des activités proposées (musculation, cardio, cours collectif...)
-- ---------------------------------------------------------------------
CREATE TABLE types_activite (
    id_activite   INT AUTO_INCREMENT PRIMARY KEY,
    nom           VARCHAR(100) NOT NULL UNIQUE,
    description   VARCHAR(255) NULL
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Table : equipements
-- Chaque équipement appartient à une salle
-- ---------------------------------------------------------------------
CREATE TABLE equipements (
    id_equipement  INT AUTO_INCREMENT PRIMARY KEY,
    nom            VARCHAR(100) NOT NULL,
    id_salle       INT NOT NULL,
    CONSTRAINT fk_equipement_salle
        FOREIGN KEY (id_salle) REFERENCES salles(id_salle)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Table : seances
-- Une séance référence : adhérent, salle, type d'activité,
-- durée, et optionnellement un équipement.
-- ---------------------------------------------------------------------
CREATE TABLE seances (
    id_seance       INT AUTO_INCREMENT PRIMARY KEY,
    id_adherent     INT NOT NULL,
    id_salle        INT NOT NULL,
    id_activite     INT NOT NULL,
    id_equipement   INT NULL,
    duree_minutes   INT NOT NULL,
    date_seance     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_seance_adherent
        FOREIGN KEY (id_adherent) REFERENCES adherents(id_adherent)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_seance_salle
        FOREIGN KEY (id_salle) REFERENCES salles(id_salle)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_seance_activite
        FOREIGN KEY (id_activite) REFERENCES types_activite(id_activite)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_seance_equipement
        FOREIGN KEY (id_equipement) REFERENCES equipements(id_equipement)
        ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT chk_duree_positive CHECK (duree_minutes > 0)
) ENGINE=InnoDB;

CREATE INDEX idx_seance_adherent ON seances(id_adherent);
CREATE INDEX idx_seance_date ON seances(date_seance);
