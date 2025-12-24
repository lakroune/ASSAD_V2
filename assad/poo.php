<?php
session_start();
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


    public function __construct() {}


    // public function __construct($nom_animal, $email, $mot_passe, $pays_utilisateur)
    // {
    //     setNonUtilisateur($nom_animal);
    //     setEmail($email);
    //     setMotPasse($mot_passe);
    //     setPaysUtilisateur($pays_utilisateur);
    // }

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

    public function setNonUtilisateur($nom_utilisateur)
    {
        $regex = '/^[a-zA-Z]{5,50}$/';
        if (preg_match($regex, $nom_utilisateur))
            $this->nom_utilisateur = $nom_utilisateur;
    }
    public function setEmail($email)
    {
        $regex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        if (preg_match($regex, $email))
            $this->email = $email;
    }

    public function setPaysUtilisateur($pays_utilisateur)
    {
        $regex = '/^[a-zA-Z]{2,50}$/';
        if (preg_match($regex, $pays_utilisateur))
            $this->pays_utilisateur = $pays_utilisateur;
    }

    public function setMotPasse($mot_passe)
    {
        $regex = '/^[A-Za-z@&1-9!?]{8,20}$/';
        if (preg_match($regex, $mot_passe))
            $this->mot_passe = $mot_passe;
    }
    public function __toString()
    {
        return "id_utilisateur" . $this->id_utilisateur;
    }
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
// echo $user->seconnecter("admin@admin", "admin")."</br>";
// echo $user->approuver_guide(2);

// echo $_SESSION["id_utilisateur"] . "</br>";








class Admin extends Utilisateur
{
    private string $role = "admin";

    public function __construct()
    {
        return parent::__construct();
    }
    public  function getRoleUtilisateur()
    {
        return $this->role;
    }
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
    }
}


class Guide extends Utilisateur
{
    private string $role = "guide";
    private int $is_Approuver;
    private string $statut_utilisateur;

    public function __construct()
    {
        return parent::__construct();
    }
    public  function getRoleUtilisateur()
    {
        return $this->role;
    }
    public function getIsApprouver()
    {
        return $this->is_Approuver;
    }
    public function getStatutUtilisateur()
    {
        return $this->statut_utilisateur;
    }
    public function setStatutUtilisateur(int $statut_utilisateur)
    {
       if($statut_utilisateur == 0 || $statut_utilisateur == 1) {
            $this->statut_utilisateur = $statut_utilisateur;
       }
    }
}

    // public function changer_statut(int $statut_utilisateur)
    // {
    //     $conn = (new Connexion())->connect();
    //     $sql = "UPDATE utilisateurs SET statut_utilisateur = :statut_utilisateur WHERE role ='guide' and id_utilisateur = :id_utilisateur";
    //     try {
    //         $stmt = $conn->prepare($sql);
    //     } catch (Exception $e) {
    //         return "erreur sur sql";
    //     }

    //     if ($stmt->execute(["statut_utilisateur" => $statut_utilisateur, "id_utilisateur" => $this->id_utilisateur])) {
    //         return "statut modifie avec succes";
    //     } else {
    //         return "erreur lors de la modification du statut";
    //     }

        


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

    public function ajouter_habitat(string $nom_habitat, string $description_habitat, string $zone_zoo, string $type_climat): string
    {
        if (!empty($nom_habitat) && !empty($description_habitat) && !empty($zone_zoo) && !empty($type_climat)) {
            $conn = (new Connexion())->connect();
            $sql = "INSERT INTO habitats (nom_habitat, description_habitat, zone_zoo, type_climat) VALUES (:nom_habitat, :description_habitat, :zone_zoo, :type_climat)";
            try {
                $stmt = $conn->prepare($sql);
            } catch (Exception $e) {
                return "erreur sur sql";
            }
            $stmt->bindParam(':nom_habitat', $nom_habitat);
            $stmt->bindParam(':description_habitat', $description_habitat);
            $stmt->bindParam(':zone_zoo', $zone_zoo);
            $stmt->bindParam(':type_climat', $type_climat);

            if ($stmt->execute()) {
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
        $sql = "DELETE FROM habitats WHERE id_habitat = :id_habitat";
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
    }
    public function modifier_habitat(int $id_habitat, string $nom_habitat, string $description_habitat, string $zone_zoo, string $type_climat)
    {
        if (!empty($nom_habitat) && !empty($description_habitat) && !empty($zone_zoo) && !empty($type_climat)) {
            $conn = (new Connexion())->connect();
            $sql = "UPDATE habitats SET nom_habitat = :nom_habitat, description_habitat = :description_habitat, zone_zoo = :zone_zoo, type_climat = :type_climat WHERE id_habitat = :id_habitat";
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
    }
}

// $habitat = new Habitat();
// print_r($habitat->afficher_habitat(2));
// $habitat->modifier_habitat(3, "Savane", "Habitat de la savane africaine", "Zone X", "Tropicale");
// echo $habitat->supprimer_habitat(21);

class Animal
{
    private int $id_animal;
    private string $nom_animal;
    private string $espece_animal;
    private string $type_alimentation;
    private string $pays_origine;
    private string $description_animal;
    private string $image_url;
    private int $id_habitat;

    public function ajouter_animal(string $nom_animal, string $espece_animal, string $type_alimentation, string $pays_origine, string $description_animal, string $image_url, int $id_habitat)
    {
        if (!empty($nom_animal) && !empty($espece_animal) && !empty($type_alimentation) && !empty($pays_origine) && !empty($description_animal) && !empty($image_url) && !empty($id_habitat)) {
            $conn = (new Connexion())->connect();
            $sql = "INSERT INTO animaux (nom_animal, espece , alimentation_animal, image_url ,pays_origine, description_animal, id_habitat) VALUES ( :nom_animal, :espece_animal, :type_alimentation, :image_url, :pays_origine, :description_animal,  :id_habitat)";
            try {
                $stmt = $conn->prepare($sql);
            } catch (Exception $e) {
                return "erreur sur sql";
            }
            $stmt->bindParam(':nom_animal', $nom_animal);
            $stmt->bindParam(':espece_animal', $espece_animal);
            $stmt->bindParam(':type_alimentation', $type_alimentation);
            $stmt->bindParam(':pays_origine', $pays_origine);
            $stmt->bindParam(':description_animal', $description_animal);
            $stmt->bindParam(':image_url', $image_url);
            $stmt->bindParam(':id_habitat', $id_habitat, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return "animal ajoute avec succes";
            } else {
                return "erreur lors de l'ajout de l'animal";
            }
        } else {
            return "error les champs vide";
        }
    }

    public function supprimer_animal(int $id_animal)
    {
        $conn = (new Connexion())->connect();
        $sql = "DELETE FROM animaux WHERE id_animal = :id_animal";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return "erreur sur sql";
        }
        $stmt->bindParam(':id_animal', $id_animal);
        if ($stmt->execute()) {
            return "animal supprime avec succes";
        } else {
            return "erreur lors de la suppression de l'animal";
        }
    }
    public function modifier_animal(int $id_animal, string $nom_animal, string $espece_animal, string $type_alimentation, string $pays_origine, string $description_animal, string $image_url, int $id_habitat)
    {
        if (!empty($nom_animal) && !empty($espece_animal) && !empty($type_alimentation) && !empty($pays_origine) && !empty($description_animal) && !empty($image_url) && !empty($id_habitat)) {
            $conn = (new Connexion())->connect();
            $sql = "UPDATE animaux SET nom_animal = :nom_animal, espece = :espece_animal, alimentation_animal = :type_alimentation, pays_origine = :pays_origine, description_animal = :description_animal, image_url = :image_url, id_habitat = :id_habitat WHERE id_animal = :id_animal";
            try {
                $stmt = $conn->prepare($sql);
            } catch (Exception $e) {
                return "erreur sur sql";
            }
            $stmt->bindParam(':id_animal', $id_animal);
            $stmt->bindParam(':nom_animal', $nom_animal);
            $stmt->bindParam(":espece_animal", $espece_animal);
            $stmt->bindParam(":type_alimentation", $type_alimentation);
            $stmt->bindParam(":pays_origine", $pays_origine);
            $stmt->bindParam(":description_animal", $description_animal);
            $stmt->bindParam(":image_url", $image_url);
            $stmt->bindParam(":id_habitat", $id_habitat);

            if ($stmt->execute()) {
                return "animal modifie avec succes";
            } else {
                return "erreur lors de la modification de l'animal";
            }
        } else {
            return "error les champs vide";
        }
    }
    public function afficher_animal(int $id_animal)
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT a.*,h.nom_habitat FROM animaux a INNER JOIN habitats h on a.id_habitat=h.id_habitat WHERE id_animal = :id_animal";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return "erreur sur sql";
        }
        $stmt->bindParam(':id_animal', $id_animal);
        $stmt->execute();
        $animal = $stmt->fetch(pdo::FETCH_ASSOC);
        if ($animal) {
            return $animal;
        } else {
            return "animal non trouve";
        }
    }
}
// $chat = new Animal();
// echo $chat->modifier_animal(10,"Lion2", "Panthera leo", "Carnivore", "Afrique", "Le lion est un grand félin carnivore.", "lion.jpg", 3);
// print_r($chat->afficher_animal(10));

class Visite
{
    private int $id_visite;
    private string $titre_visite;
    private string $description_visite;
    private DateTime $dateheure_viste;
    private string $langue__visite;
    private DateTime $duree__visite;
    private string $capacite_max__visite;
    private float $prix__visite;
    private int $statut__visite;
    private int $id_guide;


    // public function reserver_visite(int $id);

}
