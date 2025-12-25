<?php

require_once 'Utilisateur.php';

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

    public function ajouterVisite($titre_visite, $description_visite, $dateheure_viste, $langue__visite, $duree__visite): bool {
        
    }
}
