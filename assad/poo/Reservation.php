<?php

require_once 'Connexion.php';



class Reservation
{
    private int $id_reservation;
    private DateTime $date_reservation;
    private int $nombre_personnes;
    private int $id_visiteur;
    private int $id_visite;

    public function __construct() {}

    public function getIdReservation(): int
    {
        return $this->id_reservation;
    }
    public function getDateReservation(): DateTime
    {
        return $this->date_reservation;
    }
    public function getNombrePersonnes(): int
    {
        return $this->nombre_personnes;
    }

    public function getIdVisiteur(): int
    {
        return $this->id_visiteur;
    }
    public function getIdVisite(): int
    {
        return $this->id_visite;
    }

    public function setNombrePersonnes(int $nombre_personnes)
    {
        if ($nombre_personnes > 0) {
            $this->nombre_personnes = $nombre_personnes;
        }
    }
    public function setIdVisiteur(int $id_visiteur)
    {
        if ($id_visiteur > 0) {
            $this->id_visiteur = $id_visiteur;
        }
    }
    public function setIdVisite(int $id_visite)
    {

        if ($id_visite > 0) {
            $this->id_visite = $id_visite;
        }
    }
    public function setDateReservation(DateTime $date_reservation)
    {
        $this->date_reservation = $date_reservation;
    }
    public function setIdReservation(int $id_reservation)
    {
        if ($id_reservation > 0) {
            $this->id_reservation = $id_reservation;
        }
    }
    public function __toString()
    {
        return "id_reservation :" . $this->getIdReservation() . " date_reservation :" . $this->getDateReservation()->format('Y-m-d H:i:s') . " nombre_personnes :" . $this->getNombrePersonnes() . " id_visiteur :" . $this->getIdVisiteur() . " id_visite :" . $this->getIdVisite();
    }

    public function reserver(): bool
    {
        $conn = (new Connexion())->connect();
        $sql = "INSERT INTO reservations (date_reservation, nb_personnes, id_utilisateur, id_visite) VALUES (:date_reservation, :nombre_personnes, :id_visiteur, :id_visite)";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->bindParam(':date_reservation', $this->date_reservation->format('Y-m-d H:i:s'));
        $stmt->bindParam(':nombre_personnes', $this->nombre_personnes);
        $stmt->bindParam(':id_visiteur', $this->id_visiteur);
        $stmt->bindParam(':id_visite', $this->id_visite);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
