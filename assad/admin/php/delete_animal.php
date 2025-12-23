<?php
session_start();
include "../../db_connect.php";


if (!isset($_SESSION['role_utilisateur']) || $_SESSION['role_utilisateur'] !== "admin") {
    header("location: ../../connexion.php?message=error_server");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_animal'])) {
    $id = intval($_POST['id_animal']);

    $stmt = $conn->prepare("DELETE FROM animaux WHERE id_animal = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            header("location: ../admin_animaux.php?message=error_server");
        } else {
            header("location: ../admin_animaux.php?message=error_server");
        }
    } else {
        header("location: ../admin_animaux.php?message=error_server");
    }

    $stmt->close();
    $conn->close();
} else {
    header("location: ../admin_animaux.php?message=error_server");
}
