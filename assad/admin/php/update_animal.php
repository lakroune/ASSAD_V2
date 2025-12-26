<?php
require_once '../../Class/Admin.php';
require_once '../../Class/Animal.php';

if (!Admin::isConnected("admin")) {
    header("location: ../../connexion.php?message=access_denied");
    exit();
}


if (
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_POST['id_animal']) &&
    isset($_POST['nom_animal']) &&
    isset($_POST['espece']) &&
    isset($_POST['alimentation_animal']) &&
    isset($_POST['image_url']) &&
    isset($_POST['id_habitat']) &&
    isset($_POST['description_animal']) &&
    isset($_POST['pays_origine'])
) {

    $id_animal = $_POST['id_animal'];
    $nom_animal = htmlspecialchars($_POST['nom_animal']);
    $espece = htmlspecialchars($_POST['espece']);
    $alimentation = htmlspecialchars($_POST['alimentation_animal']);
    $image_url = htmlspecialchars($_POST['image_url']);
    $id_habitat = $_POST['id_habitat'];
    $description = htmlspecialchars($_POST['description_animal']);
    $pays_origine = htmlspecialchars($_POST['pays_origine']);
    $animal = new Animal();

    if (
        $animal->setNomAnimal($nom_animal) &&
        $animal->setEspeceAnimal($espece) &&
        $animal->setTypeAlimentation($alimentation) &&
        $animal->setImageUrl($image_url) &&
        $animal->setIdHabitat($id_habitat) &&
        $animal->setDescriptionAnimal($description) &&
        $animal->setPaysOrigine($pays_origine) &&
        $animal->modifierAnimal($id_animal) 
    ) {

        header("Location: ../admin_animaux.php?status=success");
        exit();
    } else {

        header("Location: ../admin_animaux.php?status=error");
        exit();
    }
}
