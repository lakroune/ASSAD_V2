<?php



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
