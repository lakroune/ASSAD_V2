<?php

include "../db_connect.php";

if (
    $_SERVER['REQUEST_METHOD'] === "POST" &&
    isset($_POST['full-name'], $_POST['role'], $_POST['pays'], $_POST['reg-email'], $_POST['reg-password'])
) {

    $fullName = $_POST['full-name'];
    $pays = $_POST['pays'];
    $role = $_POST['role'];
    $email = $_POST['reg-email'];
    $password = $_POST['reg-password'];
    $Approuver_utilisateur = 1;
    if ($role === "guide") {
        $Approuver_utilisateur = 0;
    }
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO utilisateurs (nom_utilisateur,Approuver_utilisateur,pays_utilisateur, role, email, motpasse_hash) VALUES (?, ?,?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);



    $stmt->bind_param("sissss", $fullName, $Approuver_utilisateur, $pays, $role, $email, $hashedPassword);

    if ($stmt->execute()) {
        header("Location: ../connexion.php?message=user_added");
    } else {

        header("Location: ../connexion.php?error=4");
    }

    $stmt->close();
} else {
    header("Location: ../connexion.php?error=2");
    exit();
}
