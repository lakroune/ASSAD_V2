 <?php

    require_once '../../Class/Guide.php';
    require_once '../../Class/Visite.php';
    require_once '../../Class/Etape.php';

    $guide = new Guide();
    $guide->getGuide($_SESSION["id_utilisateur"]);
    if (
        ! $guide->isConnected("guide")
    ) {
        header("Location: ../../connexion.php?error=access_denied");
    }


    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id_visite = intval($_GET['id']);

        $visite = new Visite();
        $etape = new Etape();
        if ($etape->supprimerEtapesViste($id_visite) && $visite->supprimerVisite($id_visite)) {
            header("Location: ../mes_visites.php?message=success_delete");
        } else {
            header("Location: ../mes_visites.php?message=error_delete");
        }
    } else
        header("Location: mes_visites.php");

    exit();
