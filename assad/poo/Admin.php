<?php




class Admin extends Utilisateur
{
    private string $role = "admin";

    public function __construct()
    {
        return parent::__construct();
    }
    public  function getRoleUtilisateur()
    {
        return $this->role;
    }
    public function approuver_guide($id_utilisateur)
    {
        $conn = (new Connexion())->connect();
        $sql = "UPDATE utilisateurs SET Approuver_utilisateur = 1 WHERE role ='guide' and id_utilisateur = :id_utilisateur";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return "erreur sur sql";
        }

        if ($stmt->execute(["id_utilisateur" => $id_utilisateur])) {
            return "utilisateur approuve avec succes";
        } else {
            return "erreur lors de l'approbation de l'utilisateur";
        }
    }

    public function acitiver_utilisateur(int $id_utilisateur)
    {
        $conn = (new Connexion())->connect();
        $sql = "UPDATE utilisateurs SET statut_utilisateur = 1 WHERE (role ='guide' or role ='visiteur') and id_utilisateur = :id_utilisateur";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return "erreur sur sql";
        }
        $stmt->bindParam(':id_utilisateur', $id_utilisateur);
        if ($stmt->execute()) {
            return "statut modifie avec succes";
        } else {
            return "erreur lors de la modification du statut";
        }
    }

    public function desactiver_utilisateur(int $id_utilisateur)
    {
        $conn = (new Connexion())->connect();
        $sql = "UPDATE utilisateurs SET statut_utilisateur = 0 WHERE (role ='guide' or role ='visiteur') and id_utilisateur = :id_utilisateur";
        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
            return "erreur sur sql";
        }
        $stmt->bindParam(':id_utilisateur', $id_utilisateur);
        if ($stmt->execute()) {
            return "statut modifie avec succes";
        } else {
            return "erreur lors de la modification du statut";
        }
    }
}
