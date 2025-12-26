
<?php

class Etape
{
    private $idEtape;
    private $titreEtape;
    private $descriptionEtape;
    private $ordreEtape;
    private $idVisite;

    public function __construct() {}

    public function getIdEtape()
    {
        return $this->idEtape;
    }
    public function getTitreEtape()
    {
        return $this->titreEtape;
    }
    public function getDescriptionEtape()
    {
        return $this->descriptionEtape;
    }
    public function getOrdreEtape()
    {
        return $this->ordreEtape;
    }
    public function getIdVisite()
    {
        return $this->idVisite;
    }

    public function setTitreEtape($titreEtape)
    {

        if (strlen($titreEtape) >= 1 and strlen($titreEtape) <= 500) {
            $this->titreEtape = $titreEtape;
            return true;
        }
        return false;
    }
    public function setDescriptionEtape($descriptionEtape)
    {
        if (strlen($descriptionEtape) >= 1 and strlen($descriptionEtape) <= 500) {
            $this->descriptionEtape = $descriptionEtape;
            return true;
        }
        return false;
    }

    public function setOrdreEtape($ordreEtape)
    {
        if ($ordreEtape >= 0) {
            $this->ordreEtape = $ordreEtape;
            return true;
        }
        return false;
    }
    public function setIdVisite($idVisite)
    {
        if ($idVisite > 0) {
            $this->idVisite = $idVisite;
            return true;
        }
        return false;
    }
    public function toString()
    {
        return "idEtape=" . $this->idEtape .
            ", titreEtape='" . $this->titreEtape . "'" .
            ", descriptionEtape='" . $this->descriptionEtape . "'" .
            ", ordreEtape=" . $this->ordreEtape .
            ", idVisite=" . $this->idVisite;
    }


    public function getEtape(int $id_etape): bool|Etape
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT * FROM etapesvisite WHERE id_etape = :id";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id_etape, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                if (
                    $this->setTitreEtape($row['titre_etape']) &&
                    $this->setDescriptionEtape($row['description_etape']) &&
                    $this->setOrdreEtape((int)$row['ordre_etape']) &&
                    $this->setIdVisite((int)$row['id_visite']) &&
                    $this->idEtape = (int)$row['id_etape']
                ) {

                    return $this;
                }
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
    public static function getEtapesByViste(int $id_visite): array|bool
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT * FROM etapesvisite WHERE id_visite = :id_visite ORDER BY ordre_etape ASC";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_visite', $id_visite, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $etapes = [];
            foreach ($rows as $row) {
                $etape = new Etape();
                if (
                    $etape->setTitreEtape($row['titre_etape']) &&
                    $etape->setDescriptionEtape($row['description_etape']) &&
                    $etape->setOrdreEtape((int)$row['ordre_etape']) &&
                    $etape->setIdVisite((int)$row['id_visite']) &&
                    $etape->idEtape = (int)$row['id_etape']
                ) {
                    $etapes[] = $etape;
                }
            }
            return $etapes;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>