-- Migration: Add id_equipement column to SEANCE table
USE fitconnect;

ALTER TABLE SEANCE ADD COLUMN id_equipement INT NULL AFTER id_activite;
ALTER TABLE SEANCE ADD CONSTRAINT fk_seance_equipement FOREIGN KEY (id_equipement) REFERENCES EQUIPEMENT(id_equipement);
