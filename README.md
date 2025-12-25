#  ASSAD - Zoo Virtuel 

## Présentation du Projet
À l’occasion de la **Coupe d’Afrique des Nations 2025** organisée au Maroc, le projet **ASSAD** est un zoo virtuel dédié à la promotion des lions de l’Atlas et de la faune africaine. Le site propose une expérience immersive pour les supporters et les familles, mêlant éducation, conservation et interactivité.

---

## Fonctionnalités principales

### Gestion des Utilisateurs
- **Système de rôles** : Visiteur, Guide, et Administrateur (compte Admin unique hard-codé).
- **Sécurité** : Inscription et connexion avec hachage et cryptage des mots de passe.
- **Modération** : L'administrateur peut activer/désactiver des comptes et approuver les guides.

### Pour les Guides
- **Gestion de visites** : Création, modification et annulation de visites virtuelles (prix, langue, capacité).
- **Parcours interactif** : Ajout et organisation en masse des étapes d'une visite.
- **Suivi** : Consultation de la liste des réservations en temps réel.

### Pour les Visiteurs
- **Exploration** : Fiche spéciale "Asaad – Lion des Atlas" et catalogue complet des animaux.
- **Filtres** : Recherche par habitat et par pays africain.
- **Réservations** : Inscription aux visites guidées et accès à l'historique.
- **Interactivité** : Système de notes et commentaires après chaque visite.

### Pour l'Administrateur
- **Gestion CRUD** : Contrôle total sur les fiches animaux et les habitats.
- **Tableau de bord** : Statistiques avancées (visiteurs par pays, animaux populaires, taux de réservation).

---
## Spécifications Techniques

### Base de données (Schéma Relationnel)
Le projet s'appuie sur les tables suivantes : 
- `utilisateurs` : Stockage sécurisé des profils. 
- `animaux` & `habitats` : Gestion de la biodiversité du zoo.
- `visitesguidees` & `etapesvisite` : Structure des parcours virtuels.
- `reservations` & `commentaires` : Gestion de l'interaction utilisateur. 


 
 