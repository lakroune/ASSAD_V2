<?php
require_once 'Utilisateur.php';

class VisiteurNonConnecter extends Utilisateur
{

    public function __construct()
    {
        return parent::__construct();
    }

    public function __toString()
    {
        return parent::__toString();
    }

    public function inscirire_visiteur_non_connecter(): bool
    {
        $conn = (new Connexion())->connect();
        if ($this->getRoleUtilisateur() == "guide")
            $sql = "INSERT INTO utilisateurs 
            ( nom_utilisateur, email, motpasse_hash, role, Approuver_utilisateur,pays_utilisateur)
            VALUES (:nom_utilisateur, :email_utilisateur, :mot_de_passe_utilisateur, 'guide' , 0, :pays_utilisateur)";
        else {
            if ($this->getRoleUtilisateur() == "visiteur")
                $sql = "INSERT INTO utilisateurs 
                ( nom_utilisateur, email, motpasse_hash, role, pays_utilisateur)
                VALUES (:nom_utilisateur, :email_utilisateur, :mot_de_passe_utilisateur, 'visiteur'  , :pays_utilisateur)";
            else
                return false;
        }
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->bindParam(':nom_utilisateur', $this->nom_utilisateur);
        $stmt->bindParam(':email_utilisateur', $this->email);
        $stmt->bindValue(':mot_de_passe_utilisateur', password_hash($this->mot_passe, PASSWORD_BCRYPT));
        $stmt->bindParam(':pays_utilisateur', $this->pays_utilisateur);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
