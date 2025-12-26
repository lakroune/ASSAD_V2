<?php

require_once 'Connexion.php';
class Utilisateur
{
    protected int $id_utilisateur;
    protected string $nom_utilisateur;
    protected string $email;
    protected string $mot_passe;
    protected string $pays_utilisateur;
    protected string $role;


    public function __construct() {}

    public function getIdUtilisateur()
    {
        return $this->id_utilisateur;
    }
    public function getNomUtilisateur()
    {
        return $this->nom_utilisateur;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPaysUtilisateur()
    {
        return $this->pays_utilisateur;
    }
    public function getMotPasse()
    {
        return $this->mot_passe;
    }
    public  function getRoleUtilisateur()
    {
        return $this->role;
    }
    public function setRoleUtilisateur(string $role)
    {
        if ($role == "visiteur") {
            $this->role = $role;
            return true;
        } elseif ($role == "guide") {
            $this->role = $role;
            return true;
        } elseif ($role == "admin") {
            $this->role = $role;
            return true;
        }
        return false;
    }
    public function  setIdUtilisateur($id_utilisateur): bool
    {
        if (is_int($id_utilisateur) && $id_utilisateur > 0) {
            $this->id_utilisateur = $id_utilisateur;
            return true;
        }
        return false;
    }
    public function setNomUtilisateur($nom_utilisateur): bool
    {
        $regex = "/^[a-zA-ZÀ-ÿ\s'-]{5,50}$/";
        if (preg_match($regex, $nom_utilisateur)) {
            $this->nom_utilisateur = $nom_utilisateur;
            return true;
        }
        return false;
    }
    public function setEmail($email): bool
    {
        $regex = '/^[a-zA-Z0-9]{3,20}@[a-zA-Z]{2,8}\.[a-zA-Z]{2,5}$/';
        if (preg_match($regex, $email)) {
            $this->email = $email;
            return true;
        }
        return false;
    }

    public function setPaysUtilisateur($pays_utilisateur): bool
    {
        $regex =  $regex = "/^[a-zA-ZÀ-ÿ\s'-]{5,50}$/";
        if (preg_match($regex, $pays_utilisateur)) {
            $this->pays_utilisateur = $pays_utilisateur;
            return true;
        }
        return false;
    }

    public function setMotPasse($mot_passe): bool
    {
        $regex = '/^[A-Za-z@&1-9!?]{5,20}$/'; //__8
        if (preg_match($regex, $mot_passe)) {
            $this->mot_passe = $mot_passe;
            return true;
        }
        return false;
    }
    public function __toString()
    {
        return " id_utilisateur :" . $this->id_utilisateur . " nom_utilisateur :" . $this->nom_utilisateur . " email :" . $this->email . " pays_utilisateur :" . $this->pays_utilisateur . " mot_passe :" . $this->mot_passe;
    }
    public function seconnecter(): string
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT  * FROM utilisateurs  WHERE email = :email";

        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return "erreurSQL";
        }
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $hashedPassword = $user['motpasse_hash'];
            if ($user["Approuver_utilisateur"]) {
                if (password_verify($this->mot_passe, $hashedPassword)) {
                    $_SESSION['id_utilisateur'] = $user['id_utilisateur'];
                    $_SESSION['nom_utilisateur'] = $user['nom_utilisateur'];
                    $_SESSION['role_utilisateur'] = $user['role'];
                    $_SESSION['logged_in'] = TRUE;
                    return $user["role"];
                } else {
                    return "passwordInvalid";
                }
            } else {
                return "notApproved";
            }
        } else {
            return "userNotFound";
        }
    }
    public function deconnecter(): void
    {
        session_unset();
        session_destroy();
    }

    public static function isConnected(string $role="visiteur"): bool
    {
        return isset($_SESSION['logged_in']) && isset($_SESSION['role_utilisateur']) && $_SESSION['logged_in'] === TRUE &&  $_SESSION['role_utilisateur'] === $role;
    }
}

// $user = new Utilisateur();

// $user->setEmail("admin@admin.com");
// $user->setMotPasse("admin");
// $user->setIdUtilisateur(1);
// $user->setNomUtilisateur("administrateur");
// $user->setPaysUtilisateur("Maroc");



// echo  $user;
