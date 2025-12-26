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
            return true;
        }
        return false;
    }
    public function __toString()
    {
        return parent::__toString() . " role :" . $this->getRoleUtilisateur() . " approuver :" . $this->getIsApprouver();
    }


    //recuperer les info de guide
    public function  getGuide(int $id_guide)
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
                $this->setIdUtilisateur( $visiteur['id_utilisateur']) &&
                $this->setNomUtilisateur($visiteur['nom_utilisateur']) &&
                $this->setEmail($visiteur['email']) &&
                $this->setRoleUtilisateur($visiteur['role']) &&
                $this->setPaysUtilisateur($visiteur['pays_utilisateur']) &&
                $this->setIsApprouver($visiteur['Approuver_utilisateur'])
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
    public static function getAllGuides()
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT * FROM utilisateurs ";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!$results) {
                return [];
            }

            $guidesList = [];

            foreach ($results as $row) {
                $guide = new self();
                if (
                    $guide->setIdUtilisateur($row['id_utilisateur']) &&
                    $guide->setNomUtilisateur($row['nom_utilisateur']) &&
                    $guide->setEmail($row['email']) &&
                    $guide->setPaysUtilisateur($row['pays_utilisateur']) &&
                    $guide->setIsApprouver($row['Approuver_utilisateur'])
                )
                    $guidesList[] = $guide;
            }

            return $guidesList;
        } catch (Exception $e) {
            return false;
        }
    }
    public static function conuterGuides()
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT count(*)  FROM utilisateurs WHERE role = 'guide'";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchColumn();
            return $results;
        } catch (Exception $e) {
            return false;
        }
    }
}
