# FitConnect — Conception Merise (MCD / MLD)

## 1. Acteurs et entités identifiés

- **Adhérent** : personne inscrite dans une salle du réseau
- **Salle** : une des 4 salles du réseau FitConnect
- **Abonnement** : formule souscrite par un adhérent (mensuel / trimestriel / annuel)
- **Séance** : passage d'un adhérent dans une salle pour une activité donnée
- **TypeActivité** : référentiel des activités proposées
- **Équipement** : matériel disponible dans une salle, utilisable pendant une séance
- **Employé d'accueil** (acteur externe, non persisté dans le MVP — saisit les séances)

## 2. MCD (Modèle Conceptuel de Données)

```
SALLE (id_salle, nom, adresse, ville, telephone)
    │
    │ 1,n           0,n
    ├──────── INSCRIT_A ────────┐
    │                            │
ADHERENT (id_adherent, nom, prenom, email, telephone,      │
           date_naissance, date_inscription)                │
    │ 1,1                                                    │
    │                                                         │
    │ SOUSCRIT (0,n côté adhérent → 1,1 côté abonnement)     │
    │                                                         │
ABONNEMENT (id_abonnement, type, date_debut, date_fin, statut)

ADHERENT (0,n) ──── EFFECTUE ──── (1,1) SEANCE
SALLE     (0,n) ──── SE_DEROULE_DANS ──── (1,1) SEANCE
TYPE_ACTIVITE (0,n) ──── CONCERNE ──── (1,1) SEANCE
EQUIPEMENT (0,n) ──── UTILISE (optionnel, 0,1) ──── SEANCE

SEANCE (id_seance, duree_minutes, date_seance)

SALLE (1,n) ──── POSSEDE ──── (0,n) EQUIPEMENT
```

### Règles de gestion traduites
- RG1 : Un adhérent appartient à une seule salle d'inscription (cardinalité 1,1 côté ADHERENT).
- RG2 : Un adhérent ne détient qu'un seul abonnement **actif** à la fois (contrainte gérée en logique métier, la table autorise l'historique).
- RG3 : Une séance ne peut être créée que si l'abonnement de l'adhérent est valide (date du jour comprise entre date_debut et date_fin, statut = actif) → contrôlée par `SeanceService`.
- RG4 : Une séance référence obligatoirement adhérent, salle, type d'activité ; l'équipement est optionnel (cardinalité 0,1).
- RG5 : Suppression d'un adhérent interdite s'il possède des séances ou un abonnement en cours (ON DELETE RESTRICT + contrôle applicatif).

## 3. MLD (Modèle Logique de Données)

```
salles (id_salle PK, nom, adresse, ville, telephone)

adherents (id_adherent PK, nom, prenom, email, telephone,
           date_naissance, date_inscription, id_salle FK → salles)

abonnements (id_abonnement PK, type, date_debut, date_fin, statut,
             id_adherent FK → adherents)

types_activite (id_activite PK, nom, description)

equipements (id_equipement PK, nom, id_salle FK → salles)

seances (id_seance PK, id_adherent FK → adherents, id_salle FK → salles,
         id_activite FK → types_activite, id_equipement FK NULL → equipements,
         duree_minutes, date_seance)
```

## 4. Vérification de normalisation

- **1NF** : toutes les colonnes sont atomiques, pas de listes/répétitions.
- **2NF** : chaque table a une clé primaire simple (auto-incrément), pas de dépendance partielle possible.
- **3NF** : aucune colonne ne dépend d'une colonne non-clé (ex : `ville` de la salle n'est pas dupliquée dans `adherents`, on passe par la FK `id_salle`).

Le script `schema.sql` implémente strictement ce MLD.
