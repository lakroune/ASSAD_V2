
<?php
require_once 'Connexion.php';
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
        if (strlen($contenu_commentaire) > 0 && strlen($contenu_commentaire) <= 500) {
            $this->contenu_commentaire = $contenu_commentaire;
            return true;
        }
        return false;
    }
    public function setDateCommentaire(string $date_commentaire)
    {
       if(strtotime($date_commentaire) !== false) {
            $this->date_commentaire = new DateTime($date_commentaire);
            return true;
        }
        return false;
    }
    public function setNote(int $note)
    {
        if ($note >= 1 && $note <= 5) {
            $this->note = $note;
            return true;
        }
        return false;
    }
    public function setIdVisiteur(int $id_visiteur)
    {
        if ($id_visiteur > 0) {
            $this->id_visiteur = $id_visiteur;
            return true;
        }
        return false;
    }
    public function setIdVisite(int $id_visite)
    {
        if ($id_visite > 0) {
            $this->id_visite = $id_visite;
            return true;
        }
        return false;
    }
    public function setIdCommentaire(int $id_commentaire)
    {
        if ($id_commentaire > 0) {
            $this->id_commentaire = $id_commentaire;
            return true;
        }
        return false;
    }
    public function __toString()
    {
        return "Commentaire ID: " . $this->id_commentaire . "\n" .
            "Contenu: " . $this->contenu_commentaire . "\n" .
            "Date: " . $this->date_commentaire->format('Y-m-d H:i:s') . "\n" .
            "Note: " . $this->note . "\n" .
            "Visiteur ID: " . $this->id_visiteur . "\n" .
            "Visite ID: " . $this->id_visite . "\n";
    }
    // public function getCommentaire(): array
    // {
    //     return [
    //         'id_commentaire' => $this->id_commentaire,
    //         'contenu_commentaire' => $this->contenu_commentaire,
    //         'date_commentaire' => $this->date_commentaire->format('Y-m-d H:i:s'),
    //         'note' => $this->note,
    //         'id_visiteur' => $this->id_visiteur,
    //         'id_visite' => $this->id_visite
    //     ];
    // }
    // public function setCommentaire(array $data): void
    // {
    //     if (isset($data['id_commentaire'])) {
    //         $this->setIdCommentaire($data['id_commentaire']);
    //     }
    //     if (isset($data['contenu_commentaire'])) {
    //         $this->setContenuCommentaire($data['contenu_commentaire']);
    //     }
    //     if (isset($data['date_commentaire'])) {
    //         $this->setDateCommentaire($data['date_commentaire']);
    //     }
    //     if (isset($data['note'])) {
    //         $this->setNote($data['note']);
    //     }
    //     if (isset($data['id_visiteur'])) {
    //         $this->setIdVisiteur($data['id_visiteur']);
    //     }
    //     if (isset($data['id_visite'])) {
    //         $this->setIdVisite($data['id_visite']);
    //     }
    // }
    public function ajouterCommentaire(): bool
    {
        $conn = (new Connexion())->connect();
        $sql = "INSERT INTO commentaires (texte, date_commentaire, note, id_utilisateur, id_visite) VALUES (:contenu_commentaire, :date_commentaire, :note, :id_visiteur, :id_visite)";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->bindParam(':contenu_commentaire', $this->contenu_commentaire);
        $stmt->bindValue(':date_commentaire', $this->date_commentaire->format('Y-m-d H:i:s'));
        $stmt->bindParam(':note', $this->note);
        $stmt->bindParam(':id_visiteur', $this->id_visiteur);
        $stmt->bindParam(':id_visite', $this->id_visite);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getCommentaire(int $idCommentaire)
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT * FROM commentaires WHERE id_commentaire = :id_commentaire";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->bindParam(':id_commentaire', $idCommentaire);
        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (
                !empty($result)  &&
                $this->setIdCommentaire($result['id_commentaire']) &&
                $this->setContenuCommentaire($result['texte']) &&
                $this->setDateCommentaire($result['date_commentaire']) &&
                $this->setNote($result['note']) &&
                $this->setIdVisiteur($result['id_utilisateur']) &&
                $this->setIdVisite($result['id_visite'])
            )
                return $this;
        } else {
            return false;
        }
    }
}


// $comm = new Commentaire();
 
// $comm->getCommentaire(1);
// echo $comm;
