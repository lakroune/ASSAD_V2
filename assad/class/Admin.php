<?php

require_once 'Utilisateur.php';


class Admin extends Utilisateur
{


    public function __construct()
    {
        return parent::__construct();
    }


    public function __toString()
    {
        return parent::__toString();
    }
    public function approuver_guide($id_utilisateur): bool
    {
        $conn = (new Connexion())->connect();
        $sql = "UPDATE utilisateurs SET Approuver_utilisateur = 1 WHERE role ='guide' and id_utilisateur = :id_utilisateur";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }

        if ($stmt->execute(["id_utilisateur" => $id_utilisateur])) {
            return true;
        } else {
            return false;
        }
    }

    public function acitiver_utilisateur(int $id_utilisateur): bool
    {
        $conn = (new Connexion())->connect();
        $sql = "UPDATE utilisateurs SET statut_utilisateur = 1 WHERE (role ='guide' or role ='visiteur') and id_utilisateur = :id_utilisateur";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->bindParam(':id_utilisateur', $id_utilisateur);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function desactiver_utilisateur(int $id_utilisateur): bool
    {
        $conn = (new Connexion())->connect();
        $sql = "UPDATE utilisateurs SET statut_utilisateur = 0 WHERE (role ='guide' or role ='visiteur') and id_utilisateur = :id_utilisateur";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->bindParam(':id_utilisateur', $id_utilisateur);
        if ($stmt->execute()) {
            return true;
        } else {
            return  false;
        }
    }
}
