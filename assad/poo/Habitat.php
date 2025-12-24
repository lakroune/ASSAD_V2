<?php
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
