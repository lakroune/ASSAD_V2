<?php
require_once '../../Class/Visiteur.php';
require_once '../../Class/Visite.php';
require_once '../../Class/Reservation.php';

$visiteur = new Visiteur();
$visiteur->getVisiteur($_SESSION["id_utilisateur"]);
if (
    ! $visiteur->isConnected("visiteur")
) {
    header("Location: ../../connexion.php?error=access_denied");
} else {
    $reservation = new Reservation();
    if (
        $reservation->setIdVisite($_POST["id_visite"]) &&
        $reservation->setIdVisiteur($_SESSION["id_utilisateur"]) &&
        $reservation->setNombrePersonnes($_POST["nb_personnes"]) &&
        $reservation->reserver()
    ) {
        header("Location: ../reservation.php?id_visite=success_reservation");
    } else {
        header("Location: ../reservation.php?id_visite=error_reservation");
    }
}
