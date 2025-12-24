<?php
require_once 'Utilisateur.php';

class Visiteur extends Utilisateur
{
    private string $statut_utilisateur;
    public function __construct()
    {
        return parent::__construct();
    }


    public function getStatutUtilisateur()
    {
        return $this->statut_utilisateur;
    }
    public function setStatutUtilisateur(int $statut_utilisateur)
    {
        if ($statut_utilisateur == 0 || $statut_utilisateur == 1) {
            $this->statut_utilisateur = $statut_utilisateur;
        }
    }

 
    public function __toString()
    {
        return parent::__toString()  . " statut :" . $this->getStatutUtilisateur();
    }
}
