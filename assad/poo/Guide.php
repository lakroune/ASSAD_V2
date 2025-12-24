<?php



class Guide extends Utilisateur
{
    private string $role = "guide";
    private int $is_Approuver;
    private string $statut_utilisateur;

    public function __construct()
    {
        return parent::__construct();
    }
    public  function getRoleUtilisateur()
    {
        return $this->role;
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
}

