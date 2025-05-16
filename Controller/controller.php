<?php
session_start();

use BO\loueur;
use DAO\loueurDAO;

require_once("Model/DAO/connexionMySQL.php");
require_once("Model/DAO/loueurDAO.php");

$dao = new loueurDAO();
$message_erreur = '';
$message_valider = '';
$logs = [];
$log = null;
$title = 'Connexion';
$vue = 'connexion';
$stats = null;
$loueur = null;

// Connexion
if(isset($_POST['btnConnexion'])) {
    if (isset($_POST['id']) && isset($_POST['nom']) && isset($_POST['motdepasse'])) {
        $utilisateur = $dao->connecteUtilisateur($_POST['id'], $_POST['nom'], $_POST['motdepasse']);
        if($utilisateur) {
            $_SESSION['id'] = $_POST['id'];
            $_SESSION['loueur_nom'] = $_POST['nom'];
            $_SESSION['isAdmin'] = $utilisateur['isAdmin'];
            // Connexion Admin
            if($utilisateur['isAdmin']) {
                $vue = 'administrateurConnecte';
                $title = 'Administrateur';
            }
            // Connexion Utilisateur
            else {
                $vue = 'utilisateurConnecte'; 
                $title = 'Loueur Connecté';
            }
        } else {
            $message_erreur = 'Identifiants incorrects';
        }
    }
}

// Les pages utilisateur
if(isset($_GET['action']) && $_GET['action'] == 'utilisateurConnecte') {
    $vue = 'utilisateurConnecte';
    $title = 'Loueur Connecté';
}

if(isset($_GET['action']) && $_GET['action'] == 'administrateurConnecte') {
    $vue = 'administrateurConnecte';
    $title = 'Administrateur Connecté';
}

if(isset($_GET['action']) && $_GET['action'] == 'mesStats') {
    $vue = 'mesStats';
    $title = 'Mes Statistiques';
    if(isset($_SESSION['id'])) {
        $stats = $dao->statsLoueur($_SESSION['id']);
    } else {
        $message_erreur = 'Vous devez être connecté pour accéder à cette page';
    }
}

if(isset($_GET['action']) && $_GET['action'] == 'mesInfos') {
    $vue = 'mesInfos';
    $title = 'Mes Informations';
    if(isset($_SESSION['id'])) {
        $loueur = $dao->findById($_SESSION['id']);
    } else {
        $message_erreur = 'Vous devez être connecté pour accéder à cette page';
    }
}

if(isset($_GET['action']) && $_GET['action'] == 'derniereStatsLoueur') {
    $vue = 'derniereStatsLoueur';
    $title = 'Dernières Statistiques';
    if(isset($_SESSION['id'])) {
        $log = $dao->derniereStatsLoueur($_SESSION['id']);
    } else {
        $message_erreur = 'Vous devez être connecté pour accéder à cette page';
    }
}

if(isset($_GET['action']) && $_GET['action'] == 'historiqueLoueur') {
    $vue = 'historiqueLoueur';
    $title = 'Historique Loueur';
    if(isset($_SESSION['id'])) {
        $logs = $dao->historiqueLoueur($_SESSION['id']);
    } else {
        $message_erreur = 'Vous devez être connecté pour accéder à cette page';
    }
}

// Les pages administrateur
if (isset($_GET['lesStats'] )) {
    $vue = 'lesStats';
}

if (isset($_GET['historiqueAdmin'] )) {
    $vue = 'historiqueAdmin';
    $dao = new LoueurDAO();
    $logs = $dao->getHistoriqueAdmin();
    if(isset($_POST['btnChercher']) && $_POST['date'] != "") {
        $logs = $dao->getHistoriqueAdminByDate($_POST['date']);
    }
}

if (isset($_GET['derniereStatsAdmin'])) {
    $vue = 'derniereStatsAdmin';
    $dao = new LoueurDAO();
    $logs = $dao->getLastDate();

    if (!is_array($logs)) {
        $logs = []; // Sécurité si la méthode échoue
    }
}

if (isset($_GET['statsParLoueur'])) {
    $vue = 'statsParLoueur';
    $dao = new LoueurDAO();
    $logs = [];

    if (isset($_POST['btnRecherche']) && !empty($_POST['id']) && !empty($_POST['date'])) {
        $log = $dao->getByLoueurByDate($_POST['id'],$_POST['date']);
        if (is_array($log)) {
            $logs = $log;
        }
    }
}

if (isset($_GET['administration'])) {
    $vue = 'administration';
}

if (isset($_GET['creerLoueur'])) {
    $vue = 'creerLoueur';
    $dao = new LoueurDAO();
    if(isset($_POST['btnValider'])) {
        if (isset($_POST['nom']) && isset($_POST['motdepasse']) && isset($_POST['id']) && isset($_POST['pays']) && isset($_POST['email']) && isset($_POST['numTel'])) {
            if (isset($_POST['appelsKO']) && isset($_POST['timeouts']) && $_POST['appelsKO'] != "" && $_POST['timeouts'] != "") {
                $date = new DateTime();
                $loueur = new Loueur($_POST['id'], $_POST['nom'], $_POST['appelsKO'], $_POST['timeouts'], $_POST['motdepasse'], $_POST['pays'], $_POST['email'], $_POST['numTel'], $date);
                $dao->create($loueur);
                $message_valider = 'Loueur ' . $_POST['nom'] . ' créé';
            } else {
                $date = new DateTime();
                $loueur = new Loueur( (int) $_POST['id'], $_POST['nom'], 0, 0, $_POST['motdepasse'], $_POST['pays'], $_POST['email'], $_POST['numTel'], $date);
                $dao->create($loueur);
                $message_valider = 'Loueur ' . $_POST['nom'] . ' créé';
            }
        } else {
            $message_erreur = 'Vous devez remplir les champs obligatoires';
        }
    }
}

if (isset($_GET['modifierLoueur'])) {
    $vue = 'modifierLoueur';
    $dao = new LoueurDAO();
    if(isset($_POST['btnConnexion'])){
        if($_POST['id'] == TRUE ){
            if($_POST['ancienNom'] != '' && $_POST['nouveauNom'] != '' && $_POST['appelsKO'] != '' && $_POST['timeouts'] != '' && $_POST['motdepasse'] != '' && $_POST['pays'] != '' && $_POST['email'] != '' && $_POST['numTel'] != ''){
                $date = new DateTime();
                $loueur = new Loueur($_POST['id'], $_POST['nouveauNom'], $_POST['appelsKO'], $_POST['timeouts'], $_POST['motdepasse'], $_POST['pays'], $_POST['email'], $_POST['numTel'],$date);
                $dao->update($loueur,$_POST['ancienNom']);
                $message_valider = 'Loueur '. $_POST['nouveauNom'].' modifié';
            }
            else{
                $message_valider = 'Vous devez remplir tous les champs';
            }
        }
        else{
            $message_valider = 'vous devez entrer un id';
        }
    }


}


if (isset($_GET['supprimerLoueur'])) {
    $vue = 'supprimerLoueur';
    $dao = new LoueurDAO();
    if(isset($_POST['btnValider'])){
        if ($_POST['nom'] != ''){
            $dao->delete($_POST['nom']);
            $message_valider = 'Loueur '. $_POST['nom'].' supprimé';
        }
        else{
            $message_valider = 'vous devez entrer un nom';
        }
    }
}


// Déconnexion
if(isset($_GET['deco'])){
    session_unset();
    session_destroy();
    $vue = 'connexion';
}

// Inclusion des vues
include 'View/header.php';

if($vue == 'connexion') {
    include 'View/connexion.php';
} else if($vue == 'utilisateurConnecte') {
    include 'View/loueurConnecte.php';
} else if($vue == 'administrateurConnecte') {
    include 'View/administrateurConnecte.php';
} else if($vue == 'mesStats') {
    include 'View/mesStats.php';
} else if($vue == 'mesInfos') {
    include 'View/mesInformations.php';
} else if($vue == 'derniereStatsLoueur') {
    include 'View/derniereStatsLoueur.php';
} else if($vue == 'historiqueLoueur') {
    include 'View/historiqueLoueur.php';
} else if($vue == 'lesStats') {
    include 'View/LesStats.php';
} else if($vue == 'historiqueAdmin') {
    include 'View/historiqueAdmin.php';
} else if($vue == 'derniereStatsAdmin') {
    include 'View/derniereStatsAdmin.php';
} else if($vue == 'statsParLoueur') {
    include 'View/statsParLoueur.php';
} else if($vue == 'administration') {
    include 'View/administration.php';
} else if($vue == 'creerLoueur') {
    include 'View/creationLoueur.php';
} else if($vue == 'modifierLoueur') {
    include 'View/modifLoueur.php';
} else if($vue == 'supprimerLoueur') {
    include 'View/supprLoueur.php';
} else {
    echo "<p>Action non reconnue.</p>";
}

include 'View/footer.php';