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


