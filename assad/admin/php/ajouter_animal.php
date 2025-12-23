<?php
session_start();
include "../../db_connect.php";


if (!isset($_SESSION['role_utilisateur']) || $_SESSION['role_utilisateur'] !== "admin") {
    header("location: ../../connexion.php?message=error_server");
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

    if (empty($nom) || empty($espece) || empty($id_habitat)) {
        header("location: ../admin_animaux.php");
    }

    $sql = "INSERT INTO animaux (nom_animal, espece, alimentation_animal, image_url, pays_origine, description_animal, id_habitat) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $nom, $espece, $alimentation, $image_url, $pays, $description, $id_habitat);

    if ($stmt->execute()) {
        header("location: ../admin_animaux.php?message=success");
    } else {
        header("location: ../admin_animaux.php?message=error_server");
    }

    $stmt->close();
    $conn->close();
} else {
    header("location: ../admin_animaux.php?message=error_server");
}
