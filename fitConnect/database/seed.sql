-- =====================================================================
-- FitConnect - Jeu de données de test
-- A exécuter après schema.sql
-- =====================================================================
USE fitconnect;

-- Salles du réseau
INSERT INTO salles (nom, adresse, ville, telephone) VALUES
('FitConnect Centre',    '12 Avenue Mohammed V', 'Casablanca', '0522-11-22-33'),
('FitConnect Nord',      '45 Rue des Palmiers',  'Rabat',      '0537-44-55-66'),
('FitConnect Sud',       '8 Boulevard Al Massira','Marrakech', '0524-77-88-99'),
('FitConnect Express',   '3 Rue Ibn Sina',        'Fès',       '0535-12-34-56');

-- Types d'activités
INSERT INTO types_activite (nom, description) VALUES
('Musculation',       'Séance de renforcement musculaire avec charges'),
('Cardio',            'Tapis de course, vélo, rameur'),
('Cours collectif',   'Cours encadré par un coach (RPM, Zumba, etc.)'),
('Yoga',              'Séance de yoga et étirements'),
('Crossfit',          'Entraînement fonctionnel à haute intensité');

-- Equipements par salle
INSERT INTO equipements (nom, id_salle) VALUES
('Tapis de course #1', 1), ('Rameur #1', 1), ('Banc de musculation #1', 1),
('Vélo elliptique #1', 2), ('Tapis de course #2', 2),
('Kettlebells set', 3), ('Barre olympique #1', 3),
('Tapis de yoga', 4), ('Corde à sauter', 4);

-- Adhérents
INSERT INTO adherents (nom, prenom, email, telephone, date_naissance, date_inscription, id_salle) VALUES
('Bennani',   'Youssef', 'youssef.bennani@mail.com', '0611223344', '1995-03-12', '2025-01-10', 1),
('El Amrani', 'Salma',   'salma.elamrani@mail.com',  '0622334455', '1998-07-25', '2025-02-15', 1),
('Chraibi',   'Omar',    'omar.chraibi@mail.com',    '0633445566', '1990-11-02', '2025-03-01', 2),
('Idrissi',   'Fatima',  'fatima.idrissi@mail.com',  '0644556677', '1993-05-18', '2025-04-20', 3),
('Tazi',      'Hamza',   'hamza.tazi@mail.com',      '0655667788', '2000-01-09', '2025-05-05', 4),
('Alaoui',    'Nadia',   'nadia.alaoui@mail.com',    '0666778899', '1997-09-30', '2026-01-12', 2);

-- Abonnements (un actif par adhérent)
INSERT INTO abonnements (type, date_debut, date_fin, statut, id_adherent) VALUES
('annuel',      '2026-01-01', '2026-12-31', 'actif', 1),
('mensuel',     '2026-06-01', '2026-06-30', 'actif', 2),
('trimestriel', '2026-04-01', '2026-06-30', 'actif', 3),
('annuel',      '2025-05-01', '2026-04-30', 'expire', 4),
('mensuel',     '2026-06-15', '2026-07-15', 'actif', 5),
('trimestriel', '2026-05-01', '2026-07-31', 'actif', 6);

-- Séances
INSERT INTO seances (id_adherent, id_salle, id_activite, id_equipement, duree_minutes, date_seance) VALUES
(1, 1, 1, 3, 60, '2026-06-20 08:30:00'),
(1, 1, 2, 1, 30, '2026-06-22 09:00:00'),
(2, 1, 3, NULL, 45, '2026-06-25 18:00:00'),
(3, 2, 4, NULL, 50, '2026-06-27 17:15:00'),
(5, 4, 4, 8, 40, '2026-06-28 07:45:00'),
(6, 2, 5, NULL, 55, '2026-06-29 19:00:00');
