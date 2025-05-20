<?php
require_once('connexionMySQL.php');
include('model/BO/loueur.php');

class loueurDAO extends connexionMySQL {
    public function __construct() {
        parent::__construct();
    }

    public function connecteUtilisateur($id, $nom) {
        $res = null;
        if ($this->bdd) {
            $sql = 'SELECT * FROM loueur WHERE idLoueur = ? AND nom = ?';
            $result = $this->bdd->prepare($sql);
            $result->execute( [$id, $nom]);
            $data = $result->fetch(PDO::FETCH_ASSOC);

            if($data){
                $res = $data;
            }
        }
        return $res;
    }

    public function create($loueur) {
        $sql = 'INSERT INTO loueur (idLoueur,nom,mot_de_passe,pays,email,telephone) VALUES (?,?,?,?,?,?)';
        $result = $this->bdd->prepare($sql);
        $result->execute([
            $loueur->getId(),
            $loueur->getNom(),
            $loueur->getMotdepasse(),
            $loueur->getPays(),
            $loueur->getEmail(),
            $loueur->getNumTel(),
        ]);
    }

    public function update($loueur) {
        $sql = 'UPDATE loueur SET nom = ?, mot_de_passe = ?, pays = ?, email = ?, telephone = ? WHERE idLoueur = ?';
        $result = $this->bdd->prepare($sql);
        $result->execute([
            $loueur->getNom(),
            $loueur->getMotdepasse(),
            $loueur->getPays(),
            $loueur->getEmail(),
            $loueur->getNumTel(),
            $loueur->getId(),
        ]);
    }

    public function delete($id) {
        $sql = 'DELETE FROM loueur WHERE idLoueur = ?';
        $result = $this->bdd->prepare($sql);
        $result->execute([$id]);
    }

    public function findById(int $id) {
        $sql = "SELECT idLoueur as id, nom as nom, pays as pays, email as email, telephone as telephone FROM loueur WHERE idLoueur = ?";
        $stmt = $this->getBdd()->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;

    }
}