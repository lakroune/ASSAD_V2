
<?php

class Commentaire
{
    private int $id_commentaire;
    private string $contenu_commentaire;
    private DateTime $date_commentaire;
    private int $note;
    private int $id_visiteur;
    private int $id_visite;

    public function __construct() {}

    public function getIdCommentaire(): int
    {
        return $this->id_commentaire;
    }
    public function getContenuCommentaire(): string
    {
        return $this->contenu_commentaire;
    }
    public function getDateCommentaire(): DateTime
    {
        return $this->date_commentaire;
    }

    public function getIdVisiteur(): int
    {
        return $this->id_visiteur;
    }
    public function getIdVisite(): int
    {
        return $this->id_visite;
    }
    public function getNote(): int
    {
        return $this->note;
    }

    public function setContenuCommentaire(string $contenu_commentaire)
    {
       if(strlen($contenu_commentaire) > 0 && strlen($contenu_commentaire) <= 500) {    
            $this->contenu_commentaire = $contenu_commentaire;
        }
    }
   
}
