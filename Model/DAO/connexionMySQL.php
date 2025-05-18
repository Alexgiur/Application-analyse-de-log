<?php
class connexionMySQL {
    protected ?PDO $bdd;
    public function __construct() {
        $this->bdd = null;
        try {
            $this->bdd = new PDO('mysql:host=localhost;dbname=analyse_log;charset=utf8', 'root', '');
        } catch (Exception $e) {
            die('Erreur connexion BDD : ' .$e->getMessage());
        }
        return $this->bdd;
    }

    public function getBdd(): ?PDO {
        return $this->bdd;
    }
}