<?php

include "../db_connect.php";

if (
    $_SERVER['REQUEST_METHOD'] === "POST" &&
    isset($_POST['email'], $_POST['password'])
) {

    $email = $_POST['email'];
    $password = $_POST['password'];
 

    $sql = "SELECT  * FROM utilisateurs  WHERE email = ?";

    try {
        $stmt = $conn->prepare($sql);
    } catch (Exception $e) {
        header("Location: ../connexion.php?error=db_error");
    }



    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $hashedPassword = $user['motpasse_hash'];

        if($user["Approuver_utilisateur"]){
            if (password_verify($password, $hashedPassword)) {

            session_start();

            $_SESSION['id_utilisateur'] = $user['id_utilisateur'];
            $_SESSION['nom_utilisateur'] = $user['nom_utilisateur'];
            $_SESSION['role_utilisateur'] = $user['role'];
            $_SESSION['logged_in'] = TRUE;
            if ($user['role'] === "admin")
                header("Location: ../admin");
            if ($user['role'] === "guide")
                header("Location: ../guide");
            if ($user['role'] === "visiteur")
                header("Location: ../visiteur");
        } else {
            header("Location: ../connexion.php?error=invalid2");
        }
        }else{
 header("Location: ../connexion.php?error=invalid3");
        }
    } else {
        header("Location: ../connexion.php?error=invalid1");
    }

    $stmt->close();
} else {
    header("Location: ../connexion.php");
    exit();
}


