<?php
require_once('connexionMySQL.php');
include('Model/BO/Log.php');

class LogDAO extends connexionMySQL{

    public function getHistoriqueAdmin() {
        $sql = 'SELECT * FROM `log` INNER JOIN loueur WHERE loueur.idLoueur = log.idLoueur';
        $result = $this->bdd->query($sql);
        $data = $result->fetchAll();
        return $data;
    }

    public function getHistoriqueAdminByDate($date){
        $sql = 'SELECT * FROM log INNER JOIN loueur ON loueur.id = log.loueur_id WHERE DATE(date) = ?';
        $result = $this->bdd->prepare($sql);
        $result->execute([$date]);
        $data = $result->fetchAll();
        return $data;

    }

    public function getLastDate() {
        $sql = 'SELECT * FROM log INNER JOIN loueur ON loueur.idLoueur = log.idLoueur WHERE date = (SELECT MAX(date) FROM log)';
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;
    }

    public function getByLoueurByDate($id,$date) {
        $sql = "SELECT * FROM log INNER JOIN loueur ON loueur.idLoueur = log.idLoueur WHERE log.idLoueur = ? AND date = ?";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$id, $date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSumByIdByDate($id,$date){
        $sql = "SELECT SUM(erreurKO) as total_erreur_KO, SUM(erreurTimeouts) as total_erreur_Timeouts FROM log  WHERE idLoueur = ? AND date = ?";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$id, $date]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getSumTotalByDate($date){
        $sql = "SELECT SUM(erreurKO) as total_erreur_KO, SUM(erreurTimeouts) as total_erreur_Timeouts FROM log WHERE date = ?";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$date]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function historiqueLoueur(int $id): ?array {
        $bdd = $this->getBdd();
        $sql = "SELECT erreurKO, erreurTimeouts FROM log INNER JOIN loueur ON loueur.idLoueur=log.idLoueur WHERE loueur.idLoueur = ? ORDER BY date DESC";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function derniereStatsLoueur(int $id): ?array {
        $bdd = $this->getBdd();
        $sql = "SELECT SUM(erreurKO), SUM(erreurTimeouts) FROM log INNER JOIN loueur ON loueur.idLoueur=log.idLoueur WHERE loueur.idLoueur = ? AND date >= NOW() - INTERVAL 1 DAY";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function statsLoueur(int $id): ?array {
        $bdd = $this->getBdd();
        $sql = "SELECT erreurKO, erreurTimeouts FROM log INNER JOIN loueur ON loueur.idLoueur=log.idLoueur WHERE loueur.idLoueur = ?";
        $stmt = $this->getBdd()->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function findById(int $id) {
        $bdd = $this->getBdd();
        $sql = "SELECT loueur.idLoueur, loueur.nom, loueur.pays, loueur.email, loueur.telephone, log.erreurKO, log.erreurTimeouts FROM log INNER JOIN loueur ON loueur.idLoueur=log.idLoueur WHERE loueur.idLoueur = ?";
        $stmt = $this->getBdd()->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;

    }
}