<?php



require_once '../../Class/Admin.php';
require_once '../../Class/Animal.php';
require_once '../../Class/Habitat.php';


if (!Admin::isConnected("admin")) {
    header("location: ../../connexion.php?message=access_denied");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom_animal'] ?? '';
    $espece = $_POST['espece'] ?? '';
    $alimentation = $_POST['alimentation_animal'] ?? '';
    $image_url = $_POST['image_url'] ?? '';
    $pays = $_POST['pays_origine'] ?? '';
    $description = $_POST['description_animal'] ?? '';
    $id_habitat = intval($_POST['id_habitat'] ?? 0);

    if (empty($nom) || empty($espece) || empty($id_habitat) || empty($alimentation) || empty($image_url) || empty($pays) || empty($description)) {
        header("location: ../admin_animaux.php?message=champs_vides");
    }
    $animal = new Animal();

    if (
        $animal->setNomAnimal($nom) &&
        $animal->setEspeceAnimal($espece) &&
        $animal->setTypeAlimentation($alimentation) &&
        $animal->setImageUrl($image_url) &&
        $animal->setPaysOrigine($pays) &&
        $animal->setDescriptionAnimal($description) &&
        $animal->setIdHabitat($id_habitat) &&
        $animal->ajouterAnimal()
    ) {
        header("location: ../admin_animaux.php?message=success");
        exit();
    } else {
        echo "error";
    }
} else {
    header("location: ../admin_animaux.php?message=method_not_allowed");
    exit();
}
