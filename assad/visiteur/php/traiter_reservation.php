<?php
session_start();
include "../../db_connect.php";

$id_visiteur = $_SESSION['id_utilisateur'];

$sql_status = "SELECT statut_utilisateur FROM utilisateurs WHERE id_utilisateur = ?";
$stmtStatus = $conn->prepare($sql_status);
$stmtStatus->bind_param("i", $id_visiteur);
$stmtStatus->execute();
$resultat = $stmtStatus->get_result();
$statut_utilisateur = 0;

if ($resultat->num_rows > 0) {
    $statut_utilisateur = $resultat->fetch_assoc()["statut_utilisateur"];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id_utilisateur']) && $statut_utilisateur) {
    
    $id_visite = intval($_POST['id_visite']);
    $nb_personnes_a_reserver = intval($_POST['nb_personnes']);
    $id_utilisateur = $_SESSION['id_utilisateur']; 

    
    $sql_check = "SELECT v.capacite_max__visite, COALESCE(SUM(r.nb_personnes), 0) as total_reserved 
                  FROM visitesguidees v 
                  LEFT JOIN reservations r ON v.id_visite = r.id_visite 
                  WHERE v.id_visite = ? 
                  GROUP BY v.id_visite";
    
    $stmtCheck = $conn->prepare($sql_check);
    $stmtCheck->bind_param("i", $id_visite);
    $stmtCheck->execute();
    $resCheck = $stmtCheck->get_result()->fetch_assoc();

    $capacite_max = $resCheck['capacite_max__visite'];
    $places_occupees = $resCheck['total_reserved'];
    $places_disponibles = $capacite_max - $places_occupees;

    if ($nb_personnes_a_reserver > $places_disponibles) {
        header("Location: ../reservation.php?error=full&available");
        exit();
    }
    

    $sql = "INSERT INTO reservations (id_visite, id_utilisateur, nb_personnes) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $id_visite, $id_utilisateur, $nb_personnes_a_reserver);

    if ($stmt->execute()) {
        header("Location: ../reservation.php?success=reserved");
    } else {
        header("Location: ../reservation.php?error=db_error");
    }
    exit();

} else {
    header("Location: ../reservation.php?status=Suspendu");
    exit();
}