<?php



require_once '../Class/Visiteur.php';
require_once '../Class/Visite.php';
require_once '../Class/Guide.php';
require_once '../Class/Animal.php';
require_once '../Class/Habitat.php';
require_once '../Class/Reservation.php';


if (
    Visiteur::isConnected("admin")
) {


    if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['nom_habitat']) && isset($_POST['type_climat']) && isset($_POST['description_habitat']) && isset($_POST['zone_zoo'])) {
        $nom = htmlspecialchars($_POST['nom_habitat']);
        $climat = htmlspecialchars($_POST['type_climat']);
        $description = htmlspecialchars($_POST['description_habitat']);
        $zone = htmlspecialchars($_POST['zone_zoo']);

        $habitat = new Habitat();

        if ($habitat->setNomHabitat($nom) && $habitat->setTypeClimat($climat) && $habitat->setDescriptionHabitat($description) && $habitat->setZoneZoo($zone) && $habitat->ajouterHabitat()) {
            header("Location: ../admin_habitats.php?status=added");
        } else {
            header("Location: ../admin_habitats.php?error=sql_error");
        }
    } else {
        header("Location: ../admin_habitats.php?error=missing_data");
    }
} else {
    header("Location: ../admin_habitats.php?error=unauthorized");
}
exit();
