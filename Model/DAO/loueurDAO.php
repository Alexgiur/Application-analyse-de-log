<?php
namespace DAO;

require_once('Model/DAO/ConnexionMySQL.php');
include('Model/BO/loueur.php');

class loueurDAO extends ConnexionMySQL {
    public function __construct() {
        parent::__construct();
    }

    public function connecteUtilisateur($id, $nom, $motdepasse) {
        $res = null;
        if ($this->getBdd()) {
            $sql = 'SELECT * FROM loueur WHERE id = ? AND nom = ? AND motdepasse = ?';
            $result = $this->getBdd()->prepare($sql);
            $result->execute( [$id, $nom, $motdepasse]);
            $data = $result->fetch(\PDO::FETCH_ASSOC);

            if($data){
                $res = $data;
            }
        }
        return $res;
    }

    public function getHistoriqueAdmin() {
        $sql = 'SELECT * FROM loueur';
        $result = $this->bdd->query($sql);
        $data = $result->fetchAll();
        return $data;
    }

    public function getLastDate($nom) {
        $sql = 'SELECT nom, date ,timeouts ,appelsKO FROM loueur WHERE nom = ? AND date = (SELECT MAX(date) FROM loueur WHERE nom = ?);';
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([$nom, $nom]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($loueur) {
        $sql = 'INSERT INTO loueur VALUES (?,?,?,?,?,?,?,?,?)';
        $result = $this->bdd->prepare($sql);
        $result->execute([
            $loueur->getId(),
            $loueur->getNom(),
            $loueur->getAppelsKO(),
            $loueur->getTimeouts(),
            $loueur->getMotdepasse(),
            $loueur->getPays(),
            $loueur->getEmail(),
            $loueur->getNumTel(),
            $loueur->getDate()->format('Y-m-d H:i:s'),
        ]);
    }

    public function update($loueur) {
        $sql = 'UPDATE loueur SET nom = ?, appelsKO = ?, timeouts = ?, motdepasse = ?, pays = ?, email = ?, numTel = ?, date = ? WHERE id = ?';
        $result = $this->bdd->prepare($sql);
        $result->execute([
            $loueur->getNom(),
            $loueur->getAppelsKO(),
            $loueur->getTimeouts(),
            $loueur->getMotdepasse(),
            $loueur->getPays(),
            $loueur->getEmail(),
            $loueur->getNumTel(),
            $loueur->getDate()->format('Y-m-d H:i:s'),
            $loueur->getId(),
        ]);
    }

    public function delete($nom) {
        $sql = 'DELETE FROM loueur WHERE nom = ?';
        $result = $this->bdd->prepare($sql);
        $result->execute([$nom]);
    }

    public function connecteUtilisateur2($utilisateur) {
        $res = '';
        if ($this->bdd) {
            $sql = 'SELECT * FROM loueur WHERE nom = ?';
            $result = $this->bdd->prepare($sql);
            $result->execute([$utilisateur]);

            $data = $result->fetch(PDO::FETCH_ASSOC);
            if($data) {
                $_SESSION['id'] = intval($data['identifiant']);
                $_SESSION['loueur_nom'] = $data['nom'];
                $_SESSION['appelsKO'] = intval($data['appelsKO']);
                $_SESSION['timeouts'] = intval($data['timeouts']);
                $_SESSION['pays'] = $data['pays'];
                $_SESSION['email'] = $data['email'];
                $_SESSION['numTel'] = $data['numTel'];
                $_SESSION['date'] = $data['date'];
            } else {
                $res = "Utilisateur incorrect";
            }
        }
        return $res;
    }


    public function statsLoueur(int $id): ?array {
        $sql = "SELECT appelsKO, timeouts  FROM loueur WHERE id = :id";
        $stmt = $this->getBdd()->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function derniereStatsLoueur(int $id): ?array {
        $sql = "SELECT SUM(appelsKO), SUM(timeouts) FROM loueur WHERE id = :id AND date >= NOW() - INTERVAL 1 DAY";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function historiqueLoueur(int $id): ?array {
        $sql = "SELECT appelsKO, timeouts FROM loueur WHERE id = :id ORDER BY date DESC";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }


    public function findById(int $id): ?loueur {
        $sql = "SELECT * FROM loueur WHERE id = :id";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new loueur(
                $row['id'],
                $row['nom'],
                $row['appelsKO'],
                $row['timeouts'],
                $row['motdepasse'],
                $row['pays'],
                $row['email'],
                $row['numTel'],
                new DateTime($row['date'])
            );
        }

        return null;
    }


    public function selectLoueur(): array {
        $sql = "SELECT * FROM loueur";
        $stmt = $this->bdd->query($sql);

        $loueurs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $loueurs[] = new loueur(
                $row['id'],
                $row['nom'],
                $row['appelsKO'],
                $row['timeouts'],
                $row['motdepasse'],
                $row['pays'],
                $row['email'],
                $row['numTel'],
                new DateTime($row['date'])
            );
        }

        return $loueurs;
    }
}