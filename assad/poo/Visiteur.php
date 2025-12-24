<?php
require_once 'Utilisateur.php';

class Visiteur extends Utilisateur
{
    private string $role = "visiteur";
    private string $statut_utilisateur;
    public function __construct()
    {
        return parent::__construct();
    }
    public  function getRoleUtilisateur()
    {
        return $this->role;
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
    public function setRoleUtilisateur(string $role)
    {
       if($role == "visiteur"){
        $this->role = $role;
       }
    }
    public function __toString()
    {
        return parent::__toString() . " role :" . $this->getRoleUtilisateur()." statut :" . $this->getStatutUtilisateur();
    }
}
