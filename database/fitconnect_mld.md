# MLD FitConnect - Modèle Logique de Données

## Tables

### SALLE
```
SALLE(
    id_salle PK,
    nom_salle VARCHAR(100) NOT NULL,
    adresse VARCHAR(255) NOT NULL,
    ville VARCHAR(100) NOT NULL
)
```

### ADHERENT
```
ADHERENT(
    id_adherent PK,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    telephone VARCHAR(20),
    date_inscription DATE NOT NULL,
    id_salle FK REFERENCES SALLE(id_salle)
)
```

### ABONNEMENT
```
ABONNEMENT(
    id_abonnement PK,
    type_abonnement ENUM('mensuel', 'trimestriel', 'annuel') NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    id_adherent FK REFERENCES ADHERENT(id_adherent)
)
```

### TYPE_ACTIVITE
```
TYPE_ACTIVITE(
    id_activite PK,
    libelle VARCHAR(100) NOT NULL
)
```

### EQUIPEMENT
```
EQUIPEMENT(
    id_equipement PK,
    nom_equipement VARCHAR(100) NOT NULL
)
```

### SEANCE
```
SEANCE(
    id_seance PK,
    date_seance DATETIME NOT NULL,
    duree INT NOT NULL, -- en minutes
    id_adherent FK REFERENCES ADHERENT(id_adherent),
    id_salle FK REFERENCES SALLE(id_salle),
    id_activite FK REFERENCES TYPE_ACTIVITE(id_activite),
    id_equipement FK REFERENCES EQUIPEMENT(id_equipement) NULL
)
```

## Contraintes d'intégrité

- Un adhérent ne peut avoir qu'un seul abonnement actif à la fois
- Une séance ne peut être enregistrée que si l'abonnement est valide à la date du jour
- Un adhérent ne peut pas être supprimé s'il a des séances ou un abonnement en cours
- Les dates de fin d'abonnement doivent être postérieures aux dates de début
