<?php
require_once 'Utilisateur.php';
require_once 'Reservation.php';
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
    //recuperer les info de visiteur
    public function  getVisteur(int $id_visiteur)
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT * FROM utilisateurs WHERE id_utilisateur = :id_visiteur AND role='visiteur'";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return false;
        }
        $stmt->bindParam(':id_visiteur', $id_visiteur);
        if ($stmt->execute()) {
            $visiteur = $stmt->fetch(PDO::FETCH_ASSOC);
            if (
                !empty($visiteur) &&
                $this->setIdUtilisateur($visiteur['id_utilisateur']) &&
                $this->setNomUtilisateur($visiteur['nom_utilisateur']) &&
                $this->setEmail($visiteur['email']) &&
                $this->setPaysUtilisateur($visiteur['pays_utilisateur']) &&
                $this->setStatutUtilisateur($visiteur['statut_utilisateur'])
            )
                return $this;
        } else {
            return false;
        }
    }
    public static function getAllVisiteurs(): array|bool
    {
        $conn = (new Connexion())->connect();
        $sql = "SELECT * FROM utilisateurs WHERE role = 'visiteur'";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $visiteursList = [];

            foreach ($results as $row) {
                $visiteur = new self();
                if (
                    $visiteur->setIdUtilisateur((int)$row['id_utilisateur']) &&
                    $visiteur->setNomUtilisateur($row['nom_utilisateur']) &&
                    $visiteur->setEmail($row['email']) &&
                    $visiteur->setPaysUtilisateur($row['pays_utilisateur']) &&
                    $visiteur->setStatutUtilisateur((int)$row['statut_utilisateur'])
                )
                    $visiteursList[] = $visiteur;
            }

            return $visiteursList;
        } catch (Exception $e) {
            return false;
        }
    }
    public function reserverVisite(int $idVisite, int $nombreParticipants): bool
    {
        $reservation = new Reservation();
        $reservation->setIdVisiteur($this->getIdUtilisateur());
        $reservation->setIdVisite($idVisite);
        $reservation->setNombrePersonnes($nombreParticipants);
        return $reservation->reserver();
    }
    // function pour laisser commentaire
    public function laisserCommentaire(int $idVisite, string $contenu, int $note): bool
    {
        $commentaire = new Commentaire();
        $dateNow = new DateTime();
        if (
            $commentaire->setIdVisiteur($this->getIdUtilisateur()) &&
            $commentaire->setIdVisite($idVisite) &&
            $commentaire->setContenuCommentaire($contenu) &&
            $commentaire->setDateCommentaire($dateNow->format('Y-m-d H:i:s')) &&
            $commentaire->setNote($note) && $commentaire->ajouterCommentaire()
        )
            return true;
        else
            return false;
    }
}
 