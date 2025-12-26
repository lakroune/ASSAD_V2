<?php
require_once 'Connexion.php';


class Visite
{
    private int $id_visite;
    private string $titre_visite;
    private string $description_visite;
    private DateTime $dateheure_viste;
    private string $langue__visite;
    private DateTime $duree__visite;
    private int $capacite_max__visite;
    private float $prix__visite;
    private int $statut__visite;
    private int $id_guide;


    public function __construct() {}
    //setters 
    public function getIdVisite(): int
    {
        return $this->id_visite;
    }
    public function getTitreVisite(): string
    {
        return $this->titre_visite;
    }
    public function getDescriptionVisite(): string
    {
        return $this->description_visite;
    }
    public function getDateheureVisite(): DateTime
    {
        return $this->dateheure_viste;
    }
    public function getLangueVisite(): string
    {
        return $this->langue__visite;
    }
    public function getDureeVisite(): DateTime
    {
        return $this->duree__visite;
    }
    public function getCapaciteMaxVisite(): int
    {
        return $this->capacite_max__visite;
    }
    public function getPrixVisite(): float
    {
        return $this->prix__visite;
    }
    public function getStatutVisite(): int
    {
        return $this->statut__visite;
    }

    public function getIdGuide(): int
    {
        return $this->id_guide;
    }
    public function setIdVisite(int $id_visite): bool
    {
        if ($id_visite > 0) {
            $this->id_visite = $id_visite;
            return true;
        }
        return false;
    }
    public function setTitreVisite(string $titre_visite): bool
    {
        $regix = "/^[a-zA-Z\s'-]{2,100}$/";
        if (preg_match($regix, $titre_visite)) {
            $this->titre_visite = $titre_visite;
            return true;
        }
        return false;
    }
    public function setDescriptionVisite(string $description_visite): bool
    {
        if (strlen($description_visite) >= 10 && strlen($description_visite) <= 500) {
            $this->description_visite = $description_visite;
            return true;
        }
        return false;
    }
    public function setDateheureVisite(string $dateheure_viste)
    {
        if (strtotime($dateheure_viste) !== false) {
            $this->dateheure_viste = new DateTime($dateheure_viste);
            return true;
        }
        return false;
    }
    public function setLangueVisite(string $langue__visite): bool
    {
        $regix = "/^[a-zA-Z\s'-]{2,50}$/";
        if (preg_match($regix, $langue__visite)) {
            $this->langue__visite = $langue__visite;
            return true;
        }
        return false;
    }
    public function setDureeVisite(string $duree__visite)
    {
        if (strtotime($duree__visite) !== false) {
            $this->duree__visite = new DateTime($duree__visite);
            return true;
        }
        return false;
    }
    public function setCapaciteMaxVisite(int $capacite_max__visite): bool
    {
        // NB: function is_numeric to allow string numbers
        if ($capacite_max__visite > 0) {
            $this->capacite_max__visite = $capacite_max__visite;
            return true;
        }
        return false;
    }
    public function setPrixVisite(float $prix__visite): bool
    {
        if ($prix__visite >= 0) {
            $this->prix__visite = $prix__visite;
            return true;
        }
        return false;
    }
    public function setStatutVisite(int $statut__visite): bool
    {
        if ($statut__visite == 0 || $statut__visite == 1) {
            $this->statut__visite = $statut__visite;
            return true;
        }
        return false;
    }
    public function setIdGuide(int $id_guide)
    {
        if ($id_guide > 0) {
            $this->id_guide = $id_guide;
            return true;
        }
        return false;
    }

    public function __toString()
    {
        return " id_visite :" . $this->id_visite . " titre_visite :" . $this->titre_visite . " description_visite :" . $this->description_visite . " dateheure_viste :" . $this->dateheure_viste->format('Y-m-d H:i:s') . " langue__visite :" . $this->langue__visite . " duree__visite :" . $this->duree__visite->format('H:i:s') . " capacite_max__visite :" . $this->capacite_max__visite . " prix__visite :" . $this->prix__visite . " statut__visite :" . $this->statut__visite . " id_guide :" . $this->id_guide;
    }


    public   function ajouterVisite()
    {
        $conn = (new Connexion())->connect();
        $sql = "INSERT INTO visitesguidees ( titre_visite, description_visite, dateheure_viste, langue__visite, duree__visite, capacite_max__visite, prix__visite, statut__visite, id_guide) VALUES ( :titre_visite, :description_visite, :dateheure_viste, :langue__visite, :duree__visite, :capacite_max__visite, :prix__visite, :statut__visite, :id_guide)";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        $stmt->bindParam(':titre_visite', $this->titre_visite);
        $stmt->bindParam(':description_visite', $this->description_visite);
        $stmt->bindValue(':dateheure_viste', $this->dateheure_viste->format('Y-m-d H:i:s'), PDO::PARAM_STR);
        $stmt->bindParam(':langue__visite', $this->langue__visite);
        $stmt->bindValue(':duree__visite', $this->duree__visite->format('H:i:s'));
        $stmt->bindParam(':capacite_max__visite', $this->capacite_max__visite);
        $stmt->bindParam(':prix__visite', $this->prix__visite);
        $stmt->bindParam(':statut__visite', $this->statut__visite);
        $stmt->bindParam(':id_guide', $this->id_guide);
        try {
            $stmt->execute();
            //return id_visite en db
            return $conn->lastInsertId();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function supprimerVisite(int $id_visite): bool
    {
        $conn = (new Connexion())->connect();
        $sql = "DELETE FROM visitesguidees WHERE id_visite = :id_visite";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->bindParam(':id_visite', $id_visite);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function  modifierVisite(): bool
    {
        $conn = (new Connexion())->connect();
        $sql = "UPDATE visitesguidees SET titre_visite = :titre_visite, description_visite = :description_visite, dateheure_viste = :dateheure_viste, langue__visite = :langue__visite, duree__visite = :duree__visite, capacite_max__visite = :capacite_max__visite, prix__visite = :prix__visite, statut__visite = :statut__visite, id_guide = :id_guide WHERE id_visite = :id_visite";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->bindParam(':id_visite', $this->id_visite);
        $stmt->bindParam(':titre_visite', $this->titre_visite);
        $stmt->bindParam(':description_visite', $this->description_visite);
        $stmt->bindValue(':dateheure_viste', $this->dateheure_viste->format('Y-m-d H:i:s'), PDO::PARAM_STR);
        $stmt->bindParam(':langue__visite', $this->langue__visite);
        $stmt->bindValue(':duree__visite', $this->duree__visite->format('H:i:s'));
        $stmt->bindParam(':capacite_max__visite', $this->capacite_max__visite);
        $stmt->bindParam(':prix__visite', $this->prix__visite);
        $stmt->bindParam(':statut__visite', $this->statut__visite);
        $stmt->bindParam(':id_guide', $this->id_guide);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public static function getAllVisites(): array|bool
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT * FROM visitesguidees";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $visitesList = [];

            foreach ($results as $row) {
                $visite = new self();
                if (
                    $visite->setIdVisite($row["id_visite"]) &&
                    $visite->setTitreVisite($row["titre_visite"]) &&
                    $visite->setDescriptionVisite($row["description_visite"]) &&
                    $visite->setDateheureVisite($row["dateheure_viste"]) &&
                    $visite->setLangueVisite($row["langue__visite"]) &&
                    $visite->setDureeVisite($row["duree__visite"]) &&
                    $visite->setCapaciteMaxVisite($row["capacite_max__visite"]) &&
                    $visite->setPrixVisite((float)$row["prix__visite"]) &&
                    $visite->setStatutVisite($row["statut__visite"]) &&
                    $visite->setIdGuide($row["id_guide"])
                )

                    $visitesList[] = $visite;
            }

            return $visitesList;
        } catch (Exception $e) {
            return false;
        }
    }
    public function getVisite(int $id_visite): bool|self
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT * FROM visitesguidees WHERE id_visite = :id";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id_visite, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                if (
                    $this->setIdVisite($row["id_visite"]) &&
                    $this->setTitreVisite($row["titre_visite"]) &&
                    $this->setDescriptionVisite($row["description_visite"]) &&
                    $this->setDateheureVisite($row["dateheure_viste"]) &&
                    $this->setLangueVisite($row["langue__visite"]) &&
                    $this->setDureeVisite($row["duree__visite"]) &&
                    $this->setCapaciteMaxVisite($row["capacite_max__visite"]) &&
                    $this->setPrixVisite((float)$row["prix__visite"]) &&
                    $this->setStatutVisite($row["statut__visite"]) &&
                    $this->setIdGuide($row["id_guide"])
                ) {
                    return $this;
                }
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
    // get visite sur format array assoc
    public function visiteToAssc()

    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT * FROM visitesguidees WHERE id_visite = :id";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $this->id_visite, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (Exception $e) {
            return false;
        }
    }
    public static function counterVisites(): int
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT COUNT(*) as count FROM visitesguidees";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)$row['count'];
        } catch (Exception $e) {
            return 0;
        }
    }
    public static function getProchaineVisiteByGuide(int $id_guide)
    {
        $conn = (new Connexion())->connect();
        //get the next visit  near the current time
        $sql = "SELECT * FROM visitesguidees WHERE id_guide = :id_guide AND dateheure_viste > NOW() ORDER BY dateheure_viste ASC LIMIT 1";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_guide', $id_guide, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $visite = new self();
                if (
                    $visite->setIdVisite($row["id_visite"]) &&
                    $visite->setTitreVisite($row["titre_visite"]) &&
                    $visite->setDescriptionVisite($row["description_visite"]) &&
                    $visite->setDateheureVisite($row["dateheure_viste"]) &&
                    $visite->setLangueVisite($row["langue__visite"]) &&
                    $visite->setDureeVisite($row["duree__visite"]) &&
                    $visite->setCapaciteMaxVisite($row["capacite_max__visite"]) &&
                    $visite->setPrixVisite((float)$row["prix__visite"]) &&
                    $visite->setStatutVisite($row["statut__visite"]) &&
                    $visite->setIdGuide($row["id_guide"])
                ) {
                    return $visite;
                }
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
    public function getVisitesByGuide(int $id_guide): bool|array
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT * FROM visitesguidees WHERE id_guide = :id_guide";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_guide', $id_guide, PDO::PARAM_INT);
            $stmt->execute();
            $visites = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $visite = new self();
                if (
                    $visite->setIdVisite($row["id_visite"]) &&
                    $visite->setTitreVisite($row["titre_visite"]) &&
                    $visite->setDescriptionVisite($row["description_visite"]) &&
                    $visite->setDateheureVisite($row["dateheure_viste"]) &&
                    $visite->setLangueVisite($row["langue__visite"]) &&
                    $visite->setDureeVisite($row["duree__visite"]) &&
                    $visite->setCapaciteMaxVisite($row["capacite_max__visite"]) &&
                    $visite->setPrixVisite((float)$row["prix__visite"]) &&
                    $visite->setStatutVisite($row["statut__visite"]) &&
                    $visite->setIdGuide($row["id_guide"])
                ) {
                    $visites[] = $visite;
                }
            }
            return $visites;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function counterVisitesbyGuide(int $id_guide): int
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT COUNT(*) as count FROM visitesguidees WHERE id_guide = :id_guide";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_guide', $id_guide, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)$row['count'];
        } catch (Exception $e) {
            return 0;
        }
    }
    public function getNbParticipants(): int
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT COUNT(*) as count FROM reservations WHERE id_visite = :id_visite";
        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id_visite', $this->getIdVisite(), PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)$row['count'];
        } catch (Exception $e) {
            return 0;
        }
    }
}
