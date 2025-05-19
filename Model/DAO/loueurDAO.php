<?php
require_once('connexionMySQL.php');
include('model/BO/loueur.php');

class loueurDAO extends connexionMySQL {
    public function __construct() {
        parent::__construct();
    }

    public function connecteUtilisateur($idLoueur, $nom, $mot_de_passe) {
        $res = null;
        if ($this->bdd) {
            $sql = 'SELECT * FROM loueur WHERE idLoueur = ? AND nom = ? AND mot_de_passe = ?';
            $result = $this->bdd->prepare($sql);
            $result->execute( [$idLoueur, $nom, $mot_de_passe]);
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

    
}