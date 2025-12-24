<?php



class Guide extends Utilisateur
{

    private int $is_Approuver;
    private string $statut_utilisateur;

    public function __construct()
    {
        return parent::__construct();
    }

    public function getIsApprouver()
    {
        return $this->is_Approuver;
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

    public function setIsApprouver(int $approuver)
    {
        if ($approuver == 0 || $approuver == 1) {
            $this->is_Approuver = $approuver;
        }
    }
    public function __toString()
    {
        return parent::__toString() . " role :" . $this->getRoleUtilisateur() . " approuver :" . $this->getIsApprouver() . " statut :" . $this->getStatutUtilisateur();
    }
}
