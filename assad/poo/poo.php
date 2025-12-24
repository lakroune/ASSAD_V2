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



// $user = new Admin();
// echo $user->seconnecter("admin@admin", "admin")."</br>";
// echo $user->approuver_guide(2);

// echo $_SESSION["id_utilisateur"] . "</br>";














// $habitat = new Habitat();
// print_r($habitat->afficher_habitat(2));
// $habitat->modifier_habitat(3, "Savane", "Habitat de la savane africaine", "Zone X", "Tropicale");
// echo $habitat->supprimer_habitat(21);

