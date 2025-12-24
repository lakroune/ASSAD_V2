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
    public function getDateheureViste(): DateTime
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
    public function getCapaciteMaxVisite(): string
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
    public function setDateheureViste(string $dateheure_viste)
    {
        $this->dateheure_viste = new DateTime($dateheure_viste);
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
        $this->duree__visite = new DateTime($duree__visite);
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


    public   function ajouter_visite(): bool|string
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
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function supprimer_visite(int $id_visite): bool
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
}

$vis = new Visite();
$vis->setIdVisite(1);
$vis->setTitreVisite("Visite des lions");
$vis->setDescriptionVisite("Une visite passionnante pour découvrir les lions et leur habitat.");
$vis->setDateheureViste("2024-12-15 14:00:00");
$vis->setLangueVisite("Francais");
$vis->setDureeVisite("02:00:00");
$vis->setCapaciteMaxVisite(20);
$vis->setPrixVisite(15.50);
$vis->setStatutVisite(1);
$vis->setIdGuide(3);
echo $vis->supprimer_visite(2);
