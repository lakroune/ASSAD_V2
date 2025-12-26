
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
        $this->titreEtape = $titreEtape;
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
        $this->idVisite = $idVisite;
    }
    public function toString()
    {
        return "idEtape=" . $this->idEtape .
            ", titreEtape='" . $this->titreEtape . "'" .
            ", descriptionEtape='" . $this->descriptionEtape . "'" .
            ", ordreEtape=" . $this->ordreEtape .
            ", idVisite=" . $this->idVisite;
    }
}
?>