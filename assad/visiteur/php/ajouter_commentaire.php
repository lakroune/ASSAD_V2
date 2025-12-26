 <?php

    require_once '../../Class/Visiteur.php';
    require_once '../../Class/Visite.php';
    require_once '../../Class/Commentaire.php';
    $visiteur = new Visiteur();
    $visiteur->getVisiteur($_SESSION["id_utilisateur"]);

    if (
        ! Visiteur::isConnected("visiteur")
    ) {
        header("Location: ../../connexion.php?error=access_denied");
        exit();
    } else {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_visite = $_POST['id_visite'];
            $note = intval($_POST['note']);
            $commentaire = htmlspecialchars($_POST['commentaire']);

            if ($visiteur->laisserCommentaire($id_visite, $commentaire, $note)) {
                header("Location: ../visite_details.php?message=success&id=$id_visite");
            } else {
                header("Location: ../visite_details.php?message=error&id=$id_visite");
            }
        } else {
            header("Location: ../index.php");
        }
    }
