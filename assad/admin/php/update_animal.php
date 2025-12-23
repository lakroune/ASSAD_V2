<?php
session_start();
include "../../db_connect.php";

if (
    isset($_SESSION['role_utilisateur'], $_SESSION['logged_in']) &&
    $_SESSION['role_utilisateur'] === "admin" &&
    $_SESSION['logged_in'] === TRUE
) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $id_animal = $_POST['id_animal'];
        $nom_animal = htmlspecialchars($_POST['nom_animal']);
        $espece = htmlspecialchars($_POST['espece']);
        $alimentation = htmlspecialchars($_POST['alimentation_animal']);
        $image_url = htmlspecialchars($_POST['image_url']);
        $id_habitat = $_POST['id_habitat'];
        $description = htmlspecialchars($_POST['description_animal']);

        $sql = "UPDATE animaux SET 
                nom_animal = ?, 
                espece = ?, 
                alimentation_animal = ?, 
                image_url = ?, 
                id_habitat = ?, 
                description_animal = ? 
                WHERE id_animal = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssisi", $nom_animal, $espece, $alimentation, $image_url, $id_habitat, $description, $id_animal);

        if ($stmt->execute()) {

            header("Location: ../admin_animaux.php?status=success");
        } else {

            header("Location: ../admin_animaux.php?status=error");
        }
        exit();
    }
} else {
    header("Location: ../../connexion.php?error=access_denied");
    exit();
}
