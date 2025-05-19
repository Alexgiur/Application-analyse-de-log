<?php
session_start();
use BO\loueur;
require_once("model/DAO/logDAO.php");
require_once("model/DAO/loueurDAO.php");
$ldao = new LogDAO();
$dao = new LoueurDAO();
$message_erreur = '';
$message_valider = '';
$loueurDAO = null;
$loueur = null;
$vue = 'connexion';
$logs = [];
$log = null;



if(isset($_POST['btnConnexion'])) {
    //Connexion
    if (isset($_POST['id']) && isset($_POST['nom']) && isset($_POST['motdepasse'])) {
        $utilisateur = $dao->connecteUtilisateur($_POST['id'],$_POST['nom'],$_POST['motdepasse']);
        if($utilisateur) {
            $_SESSION['id'] = $_POST['id'];
            $_SESSION['loueur_nom'] = $_POST['nom'];
            $_SESSION['isAdmin'] = $utilisateur['isAdmin'];
            //CONNEXION ADMIN
            if($utilisateur['isAdmin']) {
                $vue = 'administrateurConnecte';
                $title = 'Administrateur';
            }
            //CONNEXION UTILISATEUR
            else{
                $vue = 'utilisateurConnecte'; //à verifier
            }
        }else{
            $message_erreur = 'Identifiants incorrect';
        }

    }
}
//Les statistiques ADMIN
if (isset($_GET['lesStats'] )) {
    $vue = 'lesStats';
}

if (isset($_GET['historiqueAdmin'] )) {
    $vue = 'historiqueAdmin';
    $logs = $ldao->getHistoriqueAdmin();
    if(isset($_POST['btnChercher']) && $_POST['date'] != "") {
        $logs = $ldao->getHistoriqueAdminByDate($_POST['date']);
    }
}
// les stats de tout les loueurs
if (isset($_GET['derniereStatsAdmin'])) {
    $vue = 'derniereStatsAdmin';
    $log = $ldao->getLastDate();

    if (!is_array($log)) {
        $log = []; // Sécurité si la méthode échoue
    }
}

if (isset($_GET['statsParLoueur'])) {
    $vue = 'statsParLoueur';
    $log = [];

    if (isset($_POST['btnRecherche']) && !empty($_POST['id']) && !empty($_POST['date'])) {
        $log = $ldao->getByLoueurByDate($_POST['id'],$_POST['date']);
        $sum = $ldao->getSumByIdByDate($_POST['id'],$_POST['date']);
        $sumTotal = $ldao->getSumTotalByDate($_POST['date']);
        if (is_array($log)) {
            $log;
        }
    }
}


if (isset($_GET['administration'])) {
    $vue = 'administration';
}
if (isset($_GET['creerLoueur'])) {
    $vue = 'creerLoueur';
    if(isset($_POST['btnValider'])) {
        if (isset($_POST['nom']) && isset($_POST['motdepasse']) && isset($_POST['id']) && isset($_POST['pays']) && isset($_POST['email']) && isset($_POST['numTel'])) {

                $date = new DateTime();
                $loueur = new Loueur($_POST['id'], $_POST['nom'],$_POST['motdepasse'], $_POST['pays'], $_POST['email'], $_POST['numTel']);
                $dao->create($loueur);
                $message_valider = 'Loueur ' . $_POST['nom'] . ' créé';
        } else {
            $message_erreur = 'Vous devez remplir les champs obligatoires';
        }
    }
}

if (isset($_GET['modifierLoueur'])) {
    $vue = 'modifierLoueur';
    if(isset($_POST['btnConnexion'])){
        if($_POST['id'] == TRUE ){
            if($_POST['nouveauNom'] != '' && $_POST['motdepasse'] != '' && $_POST['pays'] != '' && $_POST['email'] != '' && $_POST['numTel'] != ''){
                $date = new DateTime();
                $loueur = new Loueur($_POST['id'], $_POST['nouveauNom'], $_POST['motdepasse'], $_POST['pays'], $_POST['email'], $_POST['numTel']);
                $dao->update($loueur);
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
    if(isset($_POST['btnValider'])){
        if ($_POST['id'] != ''){
            $dao->delete($_POST['id']);
            $message_valider = 'Loueur '. $_POST['id'].' supprimé';
        }
        else{
            $message_valider = 'vous devez entrer un nom';
        }
    }
}

if(isset($_GET['utilisateurConnecte'])) {
        $vue = 'utilisateurConnecte';
        $title = 'Loueur Connecté';
    }

if(isset($_GET['mesStatistiques'])) {
        $vue = 'mesStats';
        $title = 'Mes Statistiques';
        $stats = $ldao->statsLoueur($_SESSION['id']);
    }

if(isset($_GET['mesInformations'])) {
        $vue = 'mesInfos';
        $title = 'Mes Informations';
        $logs = $ldao->findById($_SESSION['id']);
    }

if(isset($_GET['derniereStatsLoueur'])) {
        $vue = 'derniereStatsLoueur';
        $title = 'Dernières Statistiques';
        $logs = $ldao->derniereStatsLoueur($_SESSION['id']);
    }


if(isset($_GET['historiqueLoueur'])) {
        $vue = 'historiqueLoueur';
        $title = 'Historique Loueur';
        $logs = $ldao->historiqueLoueur($_SESSION['id']);
    }

//Deconexion
if(isset($_GET['deco'])){
    session_unset();
    session_destroy();
    $vue = 'connexion';
}

include('View/header.php');
if($vue == 'connexion'){
    include('View/connexion.php');
}
if($vue == 'administrateurConnecte'){
    include('View/administrateurConnecte.php');
}
if($vue == 'lesStats'){
    include('View/LesStats.php');
}
if($vue == 'historiqueAdmin'){
    include('View/historiqueAdmin.php');
}
if($vue == 'derniereStatsAdmin'){
    include('View/derniereStatsAdmin.php');
}
if($vue == 'statsParLoueur'){
    include('View/statsParLoueur.php');
}
if($vue == 'administration'){
    include('View/administration.php');
}
if($vue == 'creerLoueur'){
    include('View/creationLoueur.php');
}
if($vue == 'modifierLoueur'){
    include('View/modifLoueur.php');
}
if($vue == 'supprimerLoueur'){
    include('View/supprLoueur.php');
}

if($vue == 'utilisateurConnecte') {
    include 'View/loueurConnecte.php';
}

if($vue == 'mesStats') {
    include 'View/mesStats.php';
}

if($vue == 'mesInfos') {
    include 'View/mesInformations.php';
}

if($vue == 'derniereStatsLoueur') {
    include 'View/derniereStatsLoueur.php';
}

if($vue == 'historiqueLoueur') {
    include 'View/historiqueLoueur.php';
}

include('view/footer.php');