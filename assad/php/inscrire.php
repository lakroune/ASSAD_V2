<?php

require_once '../class/VisiteurNonConnecter.php';

$user = new VisiteurNonConnecter();
if (
    $_SERVER['REQUEST_METHOD'] === "POST" && ($user->setNomUtilisateur($_POST['full-name']) &&
        $user->setRoleUtilisateur($_POST['role']) &&
        $user->setPaysUtilisateur($_POST['pays']) &&
        $user->setEmail($_POST['reg-email']) &&
        $user->setMotPasse($_POST['reg-password'])) && $user->inscirire_visiteur_non_connecter()
) {

    header("Location: ../connexion.php?message=success");
    exit();
} else {
    header("Location: ../connexion.php?message=error");
    exit();
}
