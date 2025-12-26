<?php
require_once '../../Class/Admin.php';
require_once '../../Class/Animal.php';

if (!Admin::isConnected("admin")) {
    header("location: ../../connexion.php?message=access_denied");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_animal'])) {
    $animal = new Animal();
    if (!empty($_POST['id_animal']) &&  $animal->supprimerAnimal($_POST['id_animal'])) {
        header("location: ../admin_animaux.php?message=success_delete");
    } else {
        header("location: ../admin_animaux.php?message=error_delete");
        exit();
    }
} else {
    header("location: ../admin_animaux.php?message=error_server");
    exit();
}
