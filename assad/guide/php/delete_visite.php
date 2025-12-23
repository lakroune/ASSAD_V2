<?php
include "../../db_connect.php";
session_start();

if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: ../../connexion.php");
    exit();
}

$id_guide = $_SESSION['id_utilisateur'];
$sql_status = "select statut_utilisateur FROM utilisateurs WHERE id_utilisateur = ?";
$stmtStatus = $conn->prepare($sql_status);
$stmtStatus->bind_param("i", $id_guide);
$stmtStatus->execute();
$resultat = $stmtStatus->get_result();
$statut_utilisateur = 0;
if ($resultat->num_rows > 0)
    $statut_utilisateur = $resultat->fetch_assoc()["statut_utilisateur"];
if (isset($_GET['id']) && !empty($_GET['id']) && $statut_utilisateur) {
    $id_visite = intval($_GET['id']);

    try {
        $sqlEtapes = "DELETE FROM etapesvisite WHERE id_visite = ?";
        $stmtEtapes = $conn->prepare($sqlEtapes);
        $stmtEtapes->bind_param("i", $id_visite);
        $stmtEtapes->execute();

        $sqlEtapes = "DELETE FROM commentaires WHERE id_visite = ?";
        $stmtEtapes = $conn->prepare($sqlEtapes);
        $stmtEtapes->bind_param("i", $id_visite);
        $stmtEtapes->execute();


        $sqlEtapes = "DELETE FROM reservations WHERE id_visite = ?";
        $stmtEtapes = $conn->prepare($sqlEtapes);
        $stmtEtapes->bind_param("i", $id_visite);
        $stmtEtapes->execute();


        $sqlVisite = "DELETE FROM visitesguidees WHERE id_visite = ? AND id_guide = ?";
        $stmtVisite = $conn->prepare($sqlVisite);
        $stmtVisite->bind_param("ii", $id_visite, $id_guide);
        $stmtVisite->execute();

        if ($stmtVisite->affected_rows > 0) {
            $conn->commit();
            header("Location: ../mes_visites.php?msg=deleted");
        } else {
            $conn->rollback();
            header("Location: ../mes_visites.php?error=unauthorized");
        }
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        die("Erreur lors de la suppression : " . $e->getMessage());
    }
} else {

    header("Location: ../mes_visites.php?status=Suspendu");
}
