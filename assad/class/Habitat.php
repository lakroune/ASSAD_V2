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
        $regix = "/^[A-Za-z\s'0-9_-]{2,50}$/";
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
        $regix = "/^[a-zA-ZÀ-ÿ\s'-]{5,50}$/";
        if (preg_match($regix, $zone_zoo)) {
            $this->zone_zoo = $zone_zoo;
            return true;
        }
        return false;
    }
    public function setTypeClimat(string $type_climat)
    {
        $regix = "/^[a-zA-ZÀ-ÿ\s'-]{5,50}$/";
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
    public function ajouterHabitat(): bool
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

    public function supprimerHabitat(int $id_habitat): bool
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
    public function modifierHabitat(): bool
    {
        $conn = (new Connexion())->connect();
        $sql = "UPDATE habitats SET nom_habitat = :nom_habitat, description_habitat = :description_habitat, zone_zoo = :zone_zoo, type_climat = :type_climat WHERE id_habitat = :id_habitat";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->bindValue(':id_habitat', $this->getIdHabitat());
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
    public function getHabitat(int $id_habitat): bool|Habitat
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT * FROM habitats WHERE id_habitat = :id";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id_habitat, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {

                if (
                    $this->setIdHabitat((int)$result['id_habitat']) &&
                    $this->setNomHabitat($result['nom_habitat']) &&
                    $this->setTypeClimat($result['type_climat']) &&
                    $this->setDescriptionHabitat($result['description_habitat']) &&
                    $this->setZoneZoo($result['zone_zoo'])
                ) {
                    return $this;
                }
            }

            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getAllHabitats(): array|bool
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT * FROM habitats";
        $allHabitats = [];

        try {
            $stmt = $conn->query($sql);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $row) {
                $h = new Habitat();
                if (
                    $h->setIdHabitat($row['id_habitat']) &&
                    $h->setNomHabitat($row['nom_habitat']) &&
                    $h->setDescriptionHabitat($row['description_habitat']) &&
                    $h->setZoneZoo($row['zone_zoo']) &&
                    $h->setTypeClimat($row['type_climat'])
                )
                    $allHabitats[] = $h;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $allHabitats;
    }
    public  function habitatPulsFrequent()
    {
        try {
            $conn = (new Connexion())->connect();
            $sql = "SELECT h.id_habitat , COUNT(*) as count from  animaux a inner JOIN habitats h
        on a.id_habitat= h.id_habitat   GROUP BY h.id_habitat  ORDER BY  count  desc LIMIT 1";
            $stmt = $conn->query($sql);
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $id_habitat = $row['id_habitat'];
                return $this->getHabitat($id_habitat);
            } else
                return false;
        } catch (Exception $e) {
            return false;
        }
    }
}
