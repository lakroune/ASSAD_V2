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
    public function afficher_utilisateur(int $id_utilisateur): Utilisateur|bool
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT * FROM utilisateurs WHERE id_utilisateur = :id_utilisateur";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->bindParam(':id_utilisateur', $id_utilisateur);
        $stmt->execute();
        $utilisateur = $stmt->fetch(pdo::FETCH_ASSOC);
        if ($utilisateur) {
            $user = new Utilisateur();
            $user->setIdUtilisateur($utilisateur['id_utilisateur']);
            $user->setNomUtilisateur($utilisateur['nom_utilisateur']);
            $user->setEmail($utilisateur['email']);
            $user->setPaysUtilisateur($utilisateur['pays_utilisateur']);
            $user->setRoleUtilisateur($utilisateur['role']);
            return $user;
        } else {
            return false;
        }
    }

    public function afficher_tous_utilisatdeurs(): array|bool
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT * FROM utilisateurs";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->execute();
        $utilisateurs = $stmt->fetchAll(pdo::FETCH_ASSOC);
        $users = [];
        foreach ($utilisateurs as $utilisateur) {
            $user = new Utilisateur();
            $user->setIdUtilisateur($utilisateur['id_utilisateur']);
            $user->setNomUtilisateur($utilisateur['nom_utilisateur']);
            $user->setEmail($utilisateur['email']);
            $user->setPaysUtilisateur($utilisateur['pays_utilisateur']);
            $user->setRoleUtilisateur($utilisateur['role']);
            $users[] = $user;
        }
        return $users;
    }

}
