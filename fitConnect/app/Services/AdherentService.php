<?php

/**
 * AdherentService — logique métier liée aux adhérents,
 * totalement indépendante de la couche de persistance (Repositories).
 */
class AdherentService
{
    private AdherentRepository $adherentRepository;

    public function __construct(AdherentRepository $adherentRepository)
    {
        $this->adherentRepository = $adherentRepository;
    }

    public function listerTous(): array
    {
        return $this->adherentRepository->findAll();
    }

    public function trouverParId(int $id): ?Adherent
    {
        return $this->adherentRepository->findById($id);
    }

    /**
     * Inscrit un nouvel adhérent après vérification des règles métier
     * (unicité de l'email notamment).
     */
    public function inscrire(array $donnees): int
    {
        if ($this->adherentRepository->findByEmail($donnees['email'])) {
            throw new RuntimeException('Un adhérent avec cet email existe déjà.');
        }

        $adherent = new Adherent(
            null,
            $donnees['nom'],
            $donnees['prenom'],
            $donnees['email'],
            $donnees['telephone'] ?? null,
            $donnees['date_naissance'] ?? null,
            $donnees['date_inscription'] ?? date('Y-m-d'),
            (int) $donnees['id_salle']
        );

        return $this->adherentRepository->create($adherent);
    }

    public function modifier(int $id, array $donnees): bool
    {
        $adherent = $this->adherentRepository->findById($id);
        if (!$adherent) {
            throw new RuntimeException("Adhérent introuvable (id={$id}).");
        }

        $adherent->setNom($donnees['nom']);
        $adherent->setPrenom($donnees['prenom']);
        $adherent->setEmail($donnees['email']);
        $adherent->setTelephone($donnees['telephone'] ?? null);
        $adherent->setDateNaissance($donnees['date_naissance'] ?? null);
        $adherent->setIdSalle((int) $donnees['id_salle']);

        return $this->adherentRepository->update($adherent);
    }

    /**
     * Règle de gestion : un adhérent ne peut pas être supprimé
     * s'il possède des séances enregistrées ou un abonnement en cours.
     */
    public function supprimer(int $id): bool
    {
        if ($this->adherentRepository->countSeances($id) > 0) {
            throw new RuntimeException('Suppression impossible : cet adhérent possède des séances enregistrées.');
        }

        if ($this->adherentRepository->countAbonnementsActifs($id) > 0) {
            throw new RuntimeException('Suppression impossible : cet adhérent possède un abonnement en cours.');
        }

        return $this->adherentRepository->delete($id);
    }
}
