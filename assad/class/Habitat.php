<?php
require_once 'Connexion.php';

class Habitat
{
    private int $id_habitat;
    private string $nom_habitat;
    private string $description_habitat;
    private string $zone_zoo;
    private string $type_climat;
    public function __construct() {}
    public function getIdHabitat(): int
    {
        return $this->id_habitat;
    }
    public function getNomHabitat(): string
    {
        return $this->nom_habitat;
    }
    public function getDescriptionHabitat(): string
    {
        return $this->description_habitat;
    }
    public function getZoneZoo(): string
    {
        return $this->zone_zoo;
    }
    public function getTypeClimat(): string
    {
        return $this->type_climat;
    }
    public function setNomHabitat(string $nom_habitat)
    {
        $regix = "/^[a-zA-Z\s'-]{2,50}$/";
        if (preg_match($regix, $nom_habitat)) {
            $this->nom_habitat = $nom_habitat;
            return true;
        }
        return false;
    }
    public function setDescriptionHabitat(string $description_habitat)
    {
        if (strlen($description_habitat) >= 10 && strlen($description_habitat) <= 500) {
            $this->description_habitat = $description_habitat;
            return true;
        }
        return false;
    }
    public function setZoneZoo(string $zone_zoo)
    {
        $regix = "/^[a-zA-Z\s'-]{2,50}$/";
        if (preg_match($regix, $zone_zoo)) {
            $this->zone_zoo = $zone_zoo;
            return true;
        }
        return false;
    }
    public function setTypeClimat(string $type_climat)
    {
        $regix = "/^[a-zA-Z\s'-]{2,50}$/";
        if (preg_match($regix, $type_climat)) {
            $this->type_climat = $type_climat;
            return true;
        }
        return false;
    }

    public function setIdHabitat(int $id_habitat)
    {
        if ($id_habitat > 0) {
            $this->id_habitat = $id_habitat;
            return true;
        }
        return false;
    }
    public function __toString()
    {
        return " id_habitat :" . $this->id_habitat . " nom_habitat :" . $this->nom_habitat . " description_habitat :" . $this->description_habitat . " zone_zoo :" . $this->zone_zoo . " type_climat :" . $this->type_climat;
    }
    public function ajouter_habitat(): bool
    {
        $conn = (new Connexion())->connect();
        $sql = "INSERT INTO habitats (nom_habitat, description_habitat, zone_zoo, type_climat) VALUES (:nom_habitat, :description_habitat, :zone_zoo, :type_climat)";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->bindParam(':nom_habitat', $this->nom_habitat);
        $stmt->bindParam(':description_habitat', $this->description_habitat);
        $stmt->bindParam(':zone_zoo', $this->zone_zoo);
        $stmt->bindParam(':type_climat', $this->type_climat);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function supprimer_habitat(int $id_habitat): bool
    {
        $conn = (new Connexion())->connect();
        $sql = "DELETE FROM habitats WHERE id_habitat = :id_habitat";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        if ($stmt->execute(["id_habitat" => $id_habitat])) {
            return true;
        } else {
            return false;
        }
    }
    public function modifier_habitat(): bool
    {
        $conn = (new Connexion())->connect();
        $sql = "UPDATE habitats SET nom_habitat = :nom_habitat, description_habitat = :description_habitat, zone_zoo = :zone_zoo, type_climat = :type_climat WHERE id_habitat = :id_habitat";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->bindParam(':id_habitat', $this->id_habitat);
        $stmt->bindParam(':nom_habitat', $this->nom_habitat);
        $stmt->bindParam(':description_habitat', $this->description_habitat);
        $stmt->bindParam(':zone_zoo', $this->zone_zoo);
        $stmt->bindParam(':type_climat', $this->type_climat);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function afficher_habitat(): array|bool
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT * FROM habitats WHERE id_habitat = :id_habitat";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->bindParam(':id_habitat', $this->id_habitat);
        $stmt->execute();
        $habitat = $stmt->fetch(pdo::FETCH_ASSOC);
        if ($habitat) {
            return $habitat;
        } else {
            return false;
        }
    }
}
