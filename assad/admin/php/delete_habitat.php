<?php



require_once '../../Class/Admin.php';
require_once '../../Class/Animal.php';
require_once '../../Class/Habitat.php';


if (!Admin::isConnected("admin")) {
    header("location: ../../connexion.php?message=access_denied");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_habitat']) && !empty($_POST['id_habitat'])) {
    $habitat = new Habitat();

    if ($habitat->supprimerHabitat($_POST['id_habitat'])) {

        header("location: ../admin_habitats.php?message=success");
    } else {
        header("location: ../admin_habitats.php?message=error");
    }
} else {
    header("location: ../admin_habitats.php?message=error_server");
}
