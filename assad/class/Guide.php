<?php

require_once 'Utilisateur.php';
require_once 'Visite.php';
class Guide extends Utilisateur
{

    private int $is_Approuver;
    public function __construct()
    {
        return parent::__construct();
    }

    public function getIsApprouver()
    {
        return $this->is_Approuver;
    }



    public function setIsApprouver(int $approuver)
    {
        if ($approuver == 0 || $approuver == 1) {
            $this->is_Approuver = $approuver;
        }
    }
    public function __toString()
    {
        return parent::__toString() . " role :" . $this->getRoleUtilisateur() . " approuver :" . $this->getIsApprouver();
    }


    //recuperer les info de guide
    public function  getVisteur(int $id_guide)
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT * FROM utilisateurs WHERE id_utilisateur = :id_guide AND role='guide'";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->bindParam(':id_guide', $id_guide);
        if ($stmt->execute()) {
            $visiteur = $stmt->fetch(PDO::FETCH_ASSOC);
            if (
                $this->setIdUtilisateur($visiteur['id_utilisateur']) &&
                $this->setNomUtilisateur($visiteur['nom_utilisateur']) &&
                $this->setEmail($visiteur['email']) &&
                $this->setPaysUtilisateur($visiteur['pays_utilisateur']) &&
                $this->setIsApprouver($visiteur['statut_utilisateur'])
            )
                return $this;
        } else {
            return false;
        }
    }

    public function ajouterVisite(string $titre_visite, string $description_visite, string $dateheure_viste, string $langue__visite, string $duree__visite, int $nombreMaxParticipants, float $prix, int $status): bool
    {
        $Visite = new Visite();
        if (
            $Visite->setIdGuide($this->getIdUtilisateur()) &&
            $Visite->setTitreVisite($titre_visite) &&
            $Visite->setDescriptionVisite($description_visite) &&
            $Visite->setDateheureVisite($dateheure_viste) &&
            $Visite->setLangueVisite($langue__visite) &&
            $Visite->setDureeVisite($duree__visite) &&
            $Visite->setCapaciteMaxVisite($nombreMaxParticipants) &&
            $Visite->setPrixVisite($prix) &&
            $Visite->setStatutVisite($status) &&
            $Visite->ajouterVisite()
        )
            return true;
        return false;
    }
    public function annulerVisite(int $idVisite): bool
    {
        $visite = new Visite();
        return $visite->supprimerVisite($idVisite);
    }
    public function modifierVisite(int $idVisite, string $titre_visite, string $description_visite, string $dateheure_viste, string $langue__visite, string $duree__visite, int $nombreMaxParticipants, float $prix, int $status): bool
    {
        $Visite = new Visite();
        if (
            $Visite->setIdGuide($this->getIdUtilisateur()) &&
            $Visite->setTitreVisite($titre_visite) &&
            $Visite->setDescriptionVisite($description_visite) &&
            $Visite->setDateheureVisite($dateheure_viste) &&
            $Visite->setLangueVisite($langue__visite) &&
            $Visite->setDureeVisite($duree__visite) &&
            $Visite->setCapaciteMaxVisite($nombreMaxParticipants) &&
            $Visite->setPrixVisite($prix) &&
            $Visite->setStatutVisite($status) &&
            $Visite->setIdVisite($idVisite) &&
            $Visite->modifierVisite()
        )
            return true;
        return false;
    }
}

// $guide = new Guide();
// $guide->setIdUtilisateur(1);
// echo $guide->modifierVisite(1, "titre", "desczzzzzzzzz", "2024-12-12 10:00:00", "francais", "02:00:00", 20, 50.0, 1) ? "Visite ajoutée avec succès" : "Echec de l'ajout de la visite";
