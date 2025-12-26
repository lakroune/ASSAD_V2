<?php

require_once "../Class/Utilisateur.php";

$user = new Utilisateur();
if (
    $_SERVER['REQUEST_METHOD'] === "POST" &&
    $user->setEmail($_POST['email']) &&
    $user->setMotPasse($_POST['password'])
) {


    $result = $user->seconnecter();


    if ($result === "admin") {
        header("Location: ../admin/");
        exit();
    } elseif ($result === "guide") {
        header("Location: ../guide/");
        exit();
    } elseif ($result === "visiteur") {
        header("Location: ../visiteur/");
        exit();
    } else {
        header("Location: ../connexion.php?message=" . $result);
        exit();
    }
} else {
    header("Location: ../connexion.php");
    exit();
}
