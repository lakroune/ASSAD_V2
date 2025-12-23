<?php

class Connexion
{
    private   $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "assad_db";

    public function connect()
    {
        // connexion avec pdo
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        return $conn;
    }
}

class Utilisateur
{
    protected int $id_utilisateur;
    protected string $nom_utilisateur;
    protected string $email;
    protected string $mot_passe;
    protected string $pays_utilisateur;
    public function seconnecter(string $email, string $password)
    {
        $conn = (new Connexion())->connect();
        if (!empty($email) and !empty($password)) {
            $sql = "SELECT  * FROM utilisateurs  WHERE email = :email";

            try {
                $stmt = $conn->prepare($sql);
            } catch (Exception $e) {
                return "erreur sur sql";
            }
            $stmt->execute(["email" => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                $hashedPassword = $user['motpasse_hash'];
                if ($user["Approuver_utilisateur"]) {
                    if (password_verify($password, $hashedPassword)) {
                        session_start();
                        $_SESSION['id_utilisateur'] = $user['id_utilisateur'];
                        $_SESSION['nom_utilisateur'] = $user['nom_utilisateur'];
                        $_SESSION['role_utilisateur'] = $user['role'];
                        $_SESSION['logged_in'] = TRUE;
                        return $user["role"];
                    } else {
                        return "mot pass invalid";
                    }
                } else {
                    return "les utilisateur non approuve";
                }
            } else {
                return "email n'exist pas ";
            }
            $stmt->close();
        } else {
            return "error les champs vide";
        }
    }
}



// $user = new Admin();
// echo $user->seconnecter("admin@admin", "admin");
// echo $user->approuver_guide(2);










class Admin extends Utilisateur
{
    private string $role = "admin";

    public function approuver_guide($id_utilisateur)
    {
        $conn = (new Connexion())->connect();
        $sql = "UPDATE utilisateurs SET Approuver_utilisateur = 1 WHERE role ='guide' and id_utilisateur = :id_utilisateur";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return "erreur sur sql";
        }

        if ($stmt->execute(["id_utilisateur" => $id_utilisateur])) {
            return "utilisateur approuve avec succes";
        } else {
            return "erreur lors de l'approbation de l'utilisateur";
        }
        $stmt->close();
    }
}


class Guide extends Utilisateur
{
    private string $role = "guide";
    private int $Approuver_utilisateur;
    private string $statut_utilisateur;
}



class Visiteur extends Utilisateur
{
    private string $role = "visiteur";
    private int $Approuver_utilisateur;
    private string $statut_utilisateur;
}



class Habitat
{
    private int $id_habitat;
    private string $nom_habitat;
    private string $description_habitat;
    private string $zone_zoo;
    private string $type_climat;

    public function ajouter_habitat(string $nom_habitat, string $description_habitat, string $zone_zoo, float $type_climat)
    {
        if (!empty($nom_habitat) && !empty($description_habitat) && !empty($zone_zoo) && !empty($type_climat)) {
            $conn = (new Connexion())->connect();
            $sql = "INSERT INTO habitats (nom_habitat, description_habitat, zone_zoo, type_climat) VALUES (:nom_habitat, :description_habitat, :zone_zoo, :type_climat)";
            try {
                $stmt = $conn->prepare($sql);
            } catch (Exception $e) {
                return "erreur sur sql";
            }

            if ($stmt->execute(["nom_habitat" => $nom_habitat, "description_habitat" => $description_habitat, "zone_zoo" => $zone_zoo, "type_climat" => $type_climat])) {
                return "habitat ajoute avec succes";
            } else {
                return "erreur lors de l'ajout de l'habitat";
            }
            $stmt->close();
        } else {
            return "error les champs vide";
        }
    }

    public function supprimer_habitat(int $id_habitat)
    {
        $conn = (new Connexion())->connect();
        $sql = "DELETE FROM habitats WHERE id_habitat = ?";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return "erreur sur sql";
        }
        if ($stmt->execute(["id_habitat" => $id_habitat])) {
            return "habitat supprime avec succes";
        } else {
            return "erreur lors de la suppression de l'habitat";
        }
        $stmt->close();
    }
    public function modifier_habitat(int $id_habitat, string $nom_habitat, string $description_habitat, string $zone_zoo, string $type_climat)
    {
        if (!empty($nom_habitat) && !empty($description_habitat) && !empty($zone_zoo) && !empty($type_climat)) {
            require("db_connect.php");
            $sql = "UPDATE habitats SET nom_habitat = :nom_habitat, description_habitat = :description_habitat, zone_zoo = :zone_zoo, type_climat = type_climat WHERE id_habitat = id_habitat";
            try {
                $stmt = $conn->prepare($sql);
            } catch (Exception $e) {
                return "erreur sur sql";
            }
            if ($stmt->execute(["id_habitat" => $id_habitat, "nom_habitat" => $nom_habitat, "description_habitat" => $description_habitat, "zone_zoo" => $zone_zoo, "type_climat" => $type_climat])) {
                return "habitat modifie avec succes";
            } else {
                return "erreur lors de la modification de l'habitat";
            }
            $stmt->close();
        } else {
            return "error les champs vide";
        }
    }
    public function afficher_habitat(int $id_habitat)
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT * FROM habitats WHERE id_habitat = :id_habitat";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return "erreur sur sql";
        }
        $stmt->bindParam(':id_habitat', $id_habitat);
        $stmt->execute();
        $habitat = $stmt->fetch(pdo::FETCH_ASSOC);
        if ($habitat) {
            return $habitat;
        } else {
            return "habitat non trouve";
        }
        $stmt->close();
    }
}

$habitat = new Habitat();
print_r($habitat->afficher_habitat(2));




