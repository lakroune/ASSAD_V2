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
            return true;
        }
        return false;
    }
    public function setIdVisiteur(int $id_visiteur)
    {
        if ($id_visiteur > 0) {
            $this->id_visiteur = $id_visiteur;
            return true;
        }
        return false;
    }
    public function setIdVisite(int $id_visite)
    {

        if ($id_visite > 0) {
            $this->id_visite = $id_visite;
            return true;
        }
        return false;
    }
    public function setDateReservation(string $date_reservation)
    {
        if (strtotime($date_reservation) !== false) {
            $this->date_reservation = new DateTime($date_reservation);
            return true;
        }
        return false;
    }
    public function setIdReservation(int $id_reservation)
    {
        if ($id_reservation > 0) {
            $this->id_reservation = $id_reservation;
            return true;
        }
        return false;
    }
    public function __toString()
    {
        return "id_reservation :" . $this->getIdReservation() . " date_reservation :" . $this->getDateReservation()->format('Y-m-d H:i:s') . " nombre_personnes :" . $this->getNombrePersonnes() . " id_visiteur :" . $this->getIdVisiteur() . " id_visite :" . $this->getIdVisite();
    }

    public function reserver(): bool
    {
        $conn = (new Connexion())->connect();
        $sql = "INSERT INTO reservations ( nb_personnes, id_utilisateur, id_visite) VALUES ( :nombre_personnes, :id_visiteur, :id_visite)";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->bindParam(':nombre_personnes', $this->nombre_personnes);
        $stmt->bindParam(':id_visiteur', $this->id_visiteur);
        $stmt->bindParam(':id_visite', $this->id_visite);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function getResrvation($idReservation) //
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT * FROM reservations WHERE id_reservations = :id_reservation";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->bindParam(':id_reservation', $idReservation);
        $stmt->execute();
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        if (
            $resultat &&
            $this->setIdReservation((int)$resultat["id_reservation"]) &&
            $this->setNombrePersonnes((int)$resultat["nb_personnes"]) &&
            $this->setIdVisiteur((int)$resultat["id_utilisateur"]) &&
            $this->setIdVisite((int)$resultat["id_visite"]) &&
            $this->setDateReservation($resultat["date_reservation"])
        )
            return $this;

        else {
            return false;
        }
    }
    public static function getAllResrvation() //
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT * FROM reservations ";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->execute();
        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $allRervation = [];
        if ($resultats) {

            foreach ($resultats as $resultat):
                $reservation = new Reservation();
                if (
                    $reservation->setIdReservation($resultat["id_reservations"]) &&
                    $reservation->setNombrePersonnes($resultat["nb_personnes"]) &&
                    $reservation->setIdVisiteur($resultat["id_utilisateur"]) &&
                    $reservation->setIdVisite($resultat["id_visite"]) &&
                    $reservation->setDateReservation($resultat["date_reservation"])
                )
                    $allRervation[] = $reservation;
            endforeach;
            return $allRervation;
        } else {
            return false;
        }
    }
    public  static function conuterReservations()
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT COUNT(*) FROM reservations ";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public static  function getResrvationByVisite($idVisite) //
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT * FROM reservations WHERE id_visite = :id_visite";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->bindParam(':id_visite', $idVisite);
        $stmt->execute();
        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $allRervation = [];
        if ($resultats) {

            foreach ($resultats as $resultat):
                $reservation = new Reservation();
                if (
                    $reservation->setIdReservation($resultat["id_reservations"]) &&
                    $reservation->setNombrePersonnes($resultat["nb_personnes"]) &&
                    $reservation->setIdVisiteur($resultat["id_utilisateur"]) &&
                    $reservation->setIdVisite($resultat["id_visite"]) &&
                    $reservation->setDateReservation($resultat["date_reservation"])
                )
                    $allRervation[] = $reservation;
            endforeach;
            return $allRervation;
        } else {
            return false;
        }
    }

    public  function getResrvationByGuide(int $idGuide) //
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT * FROM reservations r INNER JOIN visitesguidees v on r.id_visite = v.id_visite WHERE v.id_guide = :id_guide";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->bindParam(':id_guide', $idGuide);
        $stmt->execute();
        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $allRervation = [];
        if ($resultats) {

            foreach ($resultats as $resultat):
                $reservation = new Reservation();
                if (
                    $reservation->setIdReservation($resultat["id_reservations"]) &&
                    $reservation->setNombrePersonnes($resultat["nb_personnes"]) &&
                    $reservation->setIdVisiteur($resultat["id_utilisateur"]) &&
                    $reservation->setIdVisite($resultat["id_visite"]) &&
                    $reservation->setDateReservation($resultat["date_reservation"])
                )
                    $allRervation[] = $reservation;
            endforeach;
            return $allRervation;
        } else {
            return false;
        }
    }
    public static function conuterReservationsByVisite($idVisite)
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT COUNT(*) FROM reservations WHERE id_visite = :id_visite";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->bindParam(':id_visite', $idVisite);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public  function checkVisiteReserved(int $idVisite, int $idVisiteur)
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT * FROM reservations WHERE id_visite = :id_visite AND id_utilisateur = :id_utilisateur";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->bindParam(':id_visite', $idVisite);
        $stmt->bindParam(':id_utilisateur', $idVisiteur);
        if ($stmt->execute()) {
            $result = $stmt->rowCount();
            if ($result > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
