<?php
session_start();
include "../../db_connect.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['role_utilisateur'] === "admin") {
    
   
    $nom = htmlspecialchars($_POST['nom_habitat']);
    $climat = htmlspecialchars($_POST['type_climat']);
    $description = htmlspecialchars($_POST['description_habitat']);
    $zone = htmlspecialchars($_POST['zone_zoo']);

    
    $stmt = $conn->prepare("INSERT INTO habitats (nom_habitat, type_climat, description_habitat, zone_zoo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nom, $climat, $description, $zone);

    if ($stmt->execute()) {
        header("Location: ../admin_habitats.php?status=added");
    } else {
        header("Location: ../admin_habitats.php?error=sql_error");
    }
    
    $stmt->close();
    $conn->close();
} else {
    header("Location: ../admin_habitats.php?error=unauthorized");
}
exit();