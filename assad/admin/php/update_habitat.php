<?php
session_start();
include "../../db_connect.php";
if (
    !isset($_SESSION['role_utilisateur'], $_SESSION['logged_in']) ||
    $_SESSION['role_utilisateur'] !== "admin" ||
    $_SESSION['logged_in'] !== true
) {
    header("Location: ../connexion.php?error=access_denied");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_habitat'])) {

    $id_habitat = intval($_POST['id_habitat']);
    $nom = htmlspecialchars(trim($_POST['nom_habitat']));
    $climat = htmlspecialchars(trim($_POST['type_climat']));
    $zone = htmlspecialchars(trim($_POST['zone_zoo']));
    $description = htmlspecialchars(trim($_POST['description_habitat']));

    if (!empty($nom) && !empty($climat) && !empty($zone)) {

        $sql = "UPDATE habitats 
                SET nom_habitat = ?, 
                    type_climat = ?, 
                    zone_zoo = ?, 
                    description_habitat = ? 
                WHERE id_habitat = ?";

        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssssi", $nom, $climat, $zone, $description, $id_habitat);

            if ($stmt->execute()) {
                header("Location: ../admin_habitats.php?status=updated");
            } else {
                header("Location: ../admin_habitats.php?error=sql_error");
            }
            $stmt->close();
        } else {
            header("Location: ../admin_habitats.php?error=stmt_failed");
        }
    } else {
        header("Location: ../admin_habitats.php?error=empty_fields");
    }
} else {
    header("Location: ../admin_habitats.php");
}

$conn->close();
exit();
