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
        $sql = 'SELECT * FROM log INNER JOIN loueur ON loueur.idLoueur = log.idLoueur WHERE DATE(date) = ?';
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
        $sql = "SELECT DISTINCT log.idLoueur as id, loueur.nom as nom, log.date as date, log.erreurKO as appelsKO, log.erreurTimeouts as timeouts FROM log INNER JOIN loueur ON loueur.idLoueur=log.idLoueur WHERE loueur.idLoueur = ? ORDER BY date DESC";
        $stmt = $this->getBdd()->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: null;
    }

    public function delete($id){
        $sql = 'DELETE FROM log WHERE idLoueur = ?';
        $result = $this->bdd->prepare($sql);
        $result->execute([$id]);
    }

    public function derniereStatsLoueur(int $id): ?array {
    $sql = "SELECT loueur.idLoueur as id, loueur.nom as nom, DATE(log.date) as date, SUM(log.erreurKO) as appelsKO, SUM(log.erreurTimeouts) as timeouts FROM log INNER JOIN loueur ON loueur.idLoueur = log.idLoueur WHERE log.idLoueur = ? AND DATE(log.date) = CURDATE() - INTERVAL 1 DAY GROUP BY loueur.idLoueur, loueur.nom, DATE(log.date)";
    
    $stmt = $this->bdd->prepare($sql);
    $stmt->execute([$id]);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: null;
}

    public function statsLoueur(int $id): ?array {
        $sql = "SELECT erreurKO, erreurTimeouts FROM log INNER JOIN loueur ON loueur.idLoueur=log.idLoueur WHERE loueur.idLoueur = ?";
        $stmt = $this->getBdd()->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function findById(int $id) {
        $sql = "SELECT log.idLog as id, loueur.nom as nom, log.date, log.erreurKO as appelsKO, log.erreurTimeouts as timeouts FROM log INNER JOIN loueur ON loueur.idLoueur=log.idLoueur WHERE loueur.idLoueur = ?";
        $stmt = $this->getBdd()->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: null;

    }

    public function getCompareStatsLoueurByDate(int $id, string $date): ?array {
        $sqlLoueur = "SELECT SUM(erreurKO) AS appelsKO, SUM(erreurTimeouts) AS timeouts 
                  FROM log  
                  WHERE idLoueur = ? AND DATE(date) = ?";
        $stmtLoueur = $this->bdd->prepare($sqlLoueur);
        $stmtLoueur->execute([$id, $date]);
        $statsLoueur = $stmtLoueur->fetch(PDO::FETCH_ASSOC);

        $sqlTotal = "SELECT SUM(erreurKO) AS appelsKO, SUM(erreurTimeouts) AS timeouts 
                 FROM log 
                 WHERE DATE(date) = ?";
        $stmtTotal = $this->bdd->prepare($sqlTotal);
        $stmtTotal->execute([$date]);
        $statsTotales = $stmtTotal->fetch(PDO::FETCH_ASSOC);

        $statsLoueur = $statsLoueur ?: ['appelsKO' => 0, 'timeouts' => 0];
        $statsTotales = $statsTotales ?: ['appelsKO' => 0, 'timeouts' => 0];

        return [
            'date' => $date,
            'stats_loueur' => $statsLoueur,
            'stats_totales' => $statsTotales
        ];
    }

    public function getCompareStatsLoueur(int $id): array {
        $sql = "SELECT DISTINCT DATE(date) as date FROM log WHERE idLoueur = :id ORDER BY date DESC";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([':id' => $id]);
        $dates = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $historique = [];

        foreach ($dates as $date) {
            $stats = $this->getCompareStatsLoueurByDate($id, $date);
            if ($stats) {
                $historique[] = $stats;
            }
        }

        return $historique;
    }
    public function getCompareDernieresStatsLoueur(int $id): array {
        $yesterday = (new DateTime())->modify('-1 day')->format('Y-m-d');

        $sql = "SELECT COUNT(*) FROM log WHERE idLoueur = :id AND DATE(date) = :yesterday";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([':id' => $id, ':yesterday' => $yesterday]);
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            return [];
        }

        $stats = $this->getCompareStatsLoueurByDate($id, $yesterday);
        return [$stats];
    }
}