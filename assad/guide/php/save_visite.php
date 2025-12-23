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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $statut_utilisateur) {
    $id_visite = !empty($_POST['id_visite']) ? $_POST['id_visite'] : null;
    $titre = $_POST['titre_visite'];
    $description = $_POST['description_visite'];
    $dateheure = $_POST['dateheure_viste'];
    $langue = $_POST['langue__visite'];
    $prix = intval($_POST['prix__visite']);
    $capacite = intval($_POST['capacite_max__visite']);
    $etapes = isset($_POST['etapes']) ? $_POST['etapes'] : [];



    try {
        if ($id_visite) {
            $sql = "UPDATE visitesguidees SET 
                    titre_visite = ?, 
                    description_visite = ?, 
                    dateheure_viste = ?, 
                    langue__visite = ?, 
                    prix__visite = ?, 
                    capacite_max__visite = ? 
                    WHERE id_visite = ? AND id_guide = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssiiii", $titre, $description, $dateheure, $langue, $prix, $capacite, $id_visite, $id_guide);
            $stmt->execute();
        } else {

            $sql = "INSERT INTO visitesguidees (titre_visite, description_visite, dateheure_viste, langue__visite, prix__visite, capacite_max__visite, id_guide) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssiii", $titre, $description, $dateheure, $langue, $prix, $capacite, $id_guide);
            $stmt->execute();
            $id_visite = $conn->insert_id;
        }

        $sqlDelete = "DELETE FROM etapesvisite WHERE id_visite = ?";
        $stmtDel = $conn->prepare($sqlDelete);
        $stmtDel->bind_param("i", $id_visite);
        $stmtDel->execute();


        if (!empty($etapes)) {
            $sqlEtape = "INSERT INTO etapesvisite (titre_etape, description_etape, ordre_etape, id_visite) VALUES (?, ?, ?, ?)";
            $stmtEtape = $conn->prepare($sqlEtape);

            foreach ($etapes as $etape) {
                if (!empty($etape['titre'])) {
                    $t_etape = $etape['titre'];
                    $d_etape = $etape['desc'];
                    $o_etape = intval($etape['ordre']);
                    $stmtEtape->bind_param("ssii", $t_etape, $d_etape, $o_etape, $id_visite);
                    $stmtEtape->execute();
                }
            }
        }





        header("Location: ../mes_visites.php?status=success");
    } catch (Exception $e) {

        $conn->rollback();
        header("Location: ../mes_visites.php?status=Erreur");
    }
} else
    header("Location: ../mes_visites.php?status=Suspendu");
