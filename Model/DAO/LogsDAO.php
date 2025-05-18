<?php
require_once('connexionMySQL.php');
include('model/BO/Logs.php');

class LogsDAO extends connexionMySQL{

    public function getHistoriqueAdmin() {
        $sql = 'SELECT * FROM `logs` INNER JOIN loueur WHERE loueur.id = logs.loueur_id';
        $result = $this->bdd->query($sql);
        $data = $result->fetchAll();
        return $data;
    }

    public function getHistoriqueAdminByDate($date){
        $sql = 'SELECT * FROM logs INNER JOIN loueur ON loueur.id = logs.loueur_id WHERE DATE(date) = ?';
        $result = $this->bdd->prepare($sql);
        $result->execute([$date]);
        $data = $result->fetchAll();
        return $data;

    }

    public function getLastDate() {
        $sql = 'SELECT * FROM logs INNER JOIN loueur ON loueur.id = logs.loueur_id WHERE date = (SELECT MAX(date) FROM logs)';
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;
    }

    public function getByLoueurByDate($id,$date) {
        $sql = "SELECT * FROM logs INNER JOIN loueur ON loueur.id = logs.loueur_id WHERE id = ? AND date = ?";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$id, $date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSumByIdByDate($id,$date){
        $sql = "SELECT * FROM logs  WHERE nom = ? AND date = ?";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$id, $date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function historiqueLoueur(int $id): ?array {
        $sql = "SELECT appelsKO, timeouts FROM logs INNER JOIN loueur ON loueur.id=logs.loueur_id WHERE id = :id ORDER BY date DESC";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function derniereStatsLoueur(int $id): ?array {
        $sql = "SELECT SUM(appelsKO), SUM(timeouts) FROM logs INNER JOIN loueur ON loueur.id=logs.loueur_id WHERE id = :id AND date >= NOW() - INTERVAL 1 DAY";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function statsLoueur(int $id): ?array {
        $sql = "SELECT appelsKO, timeouts FROM logs INNER JOIN loueur ON loueur.id=logs.loueur_id WHERE id = :id";
        $stmt = $this->getBdd()->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }


}