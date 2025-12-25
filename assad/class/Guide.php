<?php

require_once 'Utilisateur.php';

class Guide extends Utilisateur
{

    private int $is_Approuver;
    public function __construct()
    {
        return parent::__construct();
    }

    public function getIsApprouver()
    {
        return $this->is_Approuver;
    }



    public function setIsApprouver(int $approuver)
    {
        if ($approuver == 0 || $approuver == 1) {
            $this->is_Approuver = $approuver;
        }
    }
    public function __toString()
    {
        return parent::__toString() . " role :" . $this->getRoleUtilisateur() . " approuver :" . $this->getIsApprouver();
    }
}
