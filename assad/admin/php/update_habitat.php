<?php



require_once '../../Class/Admin.php';
require_once '../../Class/Animal.php';
require_once '../../Class/Habitat.php';


if (!Admin::isConnected("admin")) {
    header("location: ../../connexion.php?message=access_denied");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_habitat'], $_POST['nom_habitat'], $_POST['type_climat'], $_POST['zone_zoo'], $_POST['description_habitat']) and !empty($_POST['id_habitat']) && !empty($_POST['nom_habitat']) && !empty($_POST['type_climat']) && !empty($_POST['zone_zoo']) && !empty($_POST['description_habitat'])) {

    // $id_habitat = ($_POST['id_habitat']);
    // $nom = htmlspecialchars(trim($_POST['nom_habitat']));
    // $climat = htmlspecialchars(trim($_POST['type_climat']));
    // $zone = htmlspecialchars(trim($_POST['zone_zoo']));
    // $description = htmlspecialchars(trim($_POST['description_habitat']));
    $habitat = new Habitat();

    if (
        $habitat->setIdHabitat($_POST["id_habitat"]) &&
        $habitat->setNomHabitat(htmlspecialchars(trim($_POST['nom_habitat']))) &&
        $habitat->setTypeClimat(htmlspecialchars(trim($_POST['type_climat']))) &&
        $habitat->setZoneZoo(htmlspecialchars(trim($_POST['zone_zoo']))) &&
        $habitat->setDescriptionHabitat(htmlspecialchars(trim($_POST['description_habitat'])))
        && $habitat->modifierHabitat()
    ) {
        header("Location: ../admin_habitats.php?status=success");
        exit();
    } else {
        header("Location: ../admin_habitats.php?status=error");
        exit();
    }
} else {
    header("Location: ../admin_habitats.php?status=error_input");
    exit();
}
