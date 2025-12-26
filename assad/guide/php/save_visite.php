<?php
require_once '../../Class/Connexion.php';
require_once '../../Class/Guide.php';
require_once '../../Class/Visite.php';
require_once '../../Class/Etape.php';


if (!Guide::isConnected("guide")) {
    header("Location: ../../connexion.php?error=access_denied");
    exit();
}

$guide = new Guide();
$id_guide = $_SESSION["id_utilisateur"];
$guide->getGuide($id_guide);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $visite = new Visite();

    // CASE 1: UPDATE (Modifier)  
    if (isset($_POST['id_visite']) && !empty($_POST['id_visite'])) {

        if (
            $visite->setIdVisite((int)$_POST["id_visite"]) &&
            $visite->setDateheureVisite($_POST['dateheure_viste']) &&
            $visite->setDureeVisite($_POST['duree__visite']) &&
            $visite->setCapaciteMaxVisite((int)$_POST['capacite_max__visite']) &&
            $visite->setPrixVisite((float)$_POST['prix__visite'])  &&
            $visite->setDescriptionVisite($_POST['description_visite']) &&
            $visite->setLangueVisite($_POST['langue__visite']) &&
            $visite->setTitreVisite($_POST['titre_visite']) &&
            $visite->setStatutVisite(0) &&
            $visite->setIdGuide($guide->getIdUtilisateur()) &&
            $visite->modifierVisite()
        ) {
            // Modification des étapes (Etapes)
            $etapes = isset($_POST['etapes']) ? $_POST['etapes'] : [];
            $eat = new Etape();
            $eat->supprimerEtapesViste((int)$_POST['id_visite']);
            foreach ($etapes as $etapeData) {
                $etap = new Etape();
                $etap->setTitreEtape($etapeData['titre']);
                $etap->setDescriptionEtape($etapeData['desc']);
                $etap->setOrdreEtape((int)$etapeData['ordre_etape']);
                $etap->setIdVisite((int)$_POST['id_visite']);
                $etap->ajouterEtape();
            }
            header("Location: ../mes_visites.php?success=visite_modifiee");
            exit();
        }
    }
    //  CASE 2: ADD (Ajouter)
    else {
        if (
            $visite->setDateheureVisite($_POST['dateheure_viste']) &&
            $visite->setDureeVisite($_POST['duree__visite']) &&
            $visite->setCapaciteMaxVisite((int)$_POST['capacite_max__visite']) &&
            $visite->setPrixVisite((float)$_POST['prix__visite'])  &&
            $visite->setDescriptionVisite($_POST['description_visite']) &&
            $visite->setLangueVisite($_POST['langue__visite']) &&
            $visite->setTitreVisite($_POST['titre_visite']) &&
            $visite->setStatutVisite(1) &&
            $visite->setIdGuide($id_guide)
        ) {
            echo "idd";
            $lastVisiteId = $visite->ajouterVisite();

            if ($lastVisiteId) {
                $etapes = isset($_POST['etapes']) ? $_POST['etapes'] : [];
                foreach ($etapes as $etapeData) {
                    $etap = new Etape();
                    $etap->setTitreEtape($etapeData['titre']);
                    $etap->setDescriptionEtape($etapeData['desc']);
                    $etap->setOrdreEtape((int)$etapeData['ordre_etape']);
                    $etap->setIdVisite((int)$lastVisiteId);
                    $etap->ajouterEtape();
                    echo  "x";
                }
                header("Location: ../mes_visites.php?success=visite_ajoute");
                exit();
            } else {
                echo "dd";
            }
        }
        else echo "rr";
    }
} else {
    header("Location: ../mes_visites.php?error=invalid_request");
    exit();
}
