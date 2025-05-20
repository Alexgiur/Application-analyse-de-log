<?php
session_start();
use BO\loueur;
require_once("Model/DAO/LogDAO.php");
require_once("Model/DAO/loueurDAO.php");
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
    if (isset($_POST['nom']) && isset($_POST['motdepasse'])) {
        $utilisateur = $dao->connecteUtilisateur($_POST['id'],$_POST['nom']);
        if($utilisateur && password_verify($_POST['motdepasse'], $utilisateur['mot_de_passe'])) {
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

                $_SESSION['email'] = $utilisateur['email'];
                $_SESSION['pays'] = $utilisateur['pays'];
                $_SESSION['telephone'] = $utilisateur['telephone'];
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
    $title = 'Les statistiques';
}

if (isset($_GET['historiqueAdmin'] )) {
    $vue = 'historiqueAdmin';
    $title = 'Historique des admins';
    $logs = $ldao->getHistoriqueAdmin();
    if(isset($_POST['btnChercher']) && $_POST['date'] != "") {
        $logs = $ldao->getHistoriqueAdminByDate($_POST['date']);
    }
}
// les stats de tout les loueurs
if (isset($_GET['derniereStatsAdmin'])) {
    $vue = 'derniereStatsAdmin';
    $title = 'Derniere statistique';
    $logs = $ldao->getLastDate();

    if (!is_array($logs)) {
        $logs = []; // Sécurité si la méthode échoue
    }
}

if (isset($_GET['statsParLoueur'])) {
    $vue = 'statsParLoueur';
    $title = 'Stats par loueur';
    $logs = [];

    if (isset($_POST['btnRecherche']) && !empty($_POST['id']) && !empty($_POST['date'])) {
        $log = $ldao->getByLoueurByDate($_POST['id'],$_POST['date']);
        $sum = $ldao->getSumByIdByDate($_POST['id'],$_POST['date']);
        $sumTotal = $ldao->getSumTotalByDate($_POST['date']);
        if (is_array($log)) {
            $logs = $log;
        }
    }
}


if (isset($_GET['administration'])) {
    $vue = 'administration';
    $title = 'Administration';
}
if (isset($_GET['creerLoueur'])) {
    $vue = 'creerLoueur';
    $title = 'Créer loueur';
    if(isset($_POST['btnValider'])) {
        if (isset($_POST['nom']) && isset($_POST['motdepasse']) && isset($_POST['id']) && isset($_POST['pays']) && isset($_POST['email']) && isset($_POST['numTel'])) {
            if (preg_match('/^0[1-9](\d{2}){4}$/', $_POST['numTel'])) {
                if(preg_match('/^[\w.-]+@[\w.-]+\.[\w]{2,6}$/ ' , $_POST['email'])) {
                    $date = new DateTime();
                    $mdp = $_POST['motdepasse'];
                    $hash = password_hash($mdp, PASSWORD_DEFAULT);
                    $loueur = new Loueur($_POST['id'], $_POST['nom'],$hash, $_POST['pays'], $_POST['email'], $_POST['numTel']);
                    $dao->create($loueur);
                    $message_valider = 'Loueur ' . $_POST['nom'] . ' créé avec succès';
                }
                else{
                    $message_erreur = 'Vous devez entrer une adresse email valide';
                }
            }
            else{
                $message_erreur = 'Vous devez entrer un numero de telephone valide';
            }
        } else {
            $message_erreur = 'Vous devez remplir les champs obligatoires';
        }
    }
}

if (isset($_GET['modifierLoueur'])) {
    $vue = 'modifierLoueur';
    $title = 'Modifier loueur';
    if(isset($_POST['btnConnexion'])){
        if($_POST['id'] == TRUE ){
            if($_POST['nouveauNom'] != '' && $_POST['motdepasse'] != '' && $_POST['pays'] != '' && $_POST['email'] != '' && $_POST['numTel'] != ''){
                if (preg_match('/^0[1-9](\d{2}){4}$/', $_POST['numTel'])) {
                    if(preg_match('/^[\w.-]+@[\w.-]+\.[\w]{2,6}$/ ' , $_POST['email'])) {
                        $date = new DateTime();
                        $mdp = $_POST['motdepasse'];
                        $hash = password_hash($mdp, PASSWORD_DEFAULT);
                        $loueur = new Loueur($_POST['id'], $_POST['nouveauNom'], $hash , $_POST['pays'], $_POST['email'], $_POST['numTel']);
                        $dao->update($loueur);
                        $message_valider = 'Loueur '. $_POST['nouveauNom'].' modifié avec succès';
                    }
                    else{
                        $message_valider = 'Vous devez entrer une adresse email valide';
                    }
                }
                else{
                    $message_valider = 'Vous devez entrer un numero de telephone valide';
                }
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
    $title = 'Supprimer loueur';
    if(isset($_POST['btnValider'])){
        if ($_POST['id'] != ''){
            $ldao->delete($_POST['id']);
            $dao->delete($_POST['id']);
            $message_valider = 'Loueur '. $_POST['id'].' supprimé avec succès';
        }
        else{
            $message_valider = 'Vous devez entrer un Id';
        }
    }
}


if(isset($_GET['utilisateurConnecte'])) {
    $vue = 'utilisateurConnecte';
    $title = 'Loueur Connecté';
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
    $stats = $ldao->getCompareDernieresStatsLoueur($_SESSION['id']);
}


if(isset($_GET['historiqueLoueur'])) {
    $vue = 'historiqueLoueur';
    $title = 'Historique Loueur';
    $logs = $ldao->historiqueLoueur($_SESSION['id']);
    $stats = $ldao->getCompareStatsLoueur($_SESSION['id']);
}

//Deconexion
if(isset($_GET['deco'])){
    session_unset();
    session_destroy();
    $vue = 'connexion';
}

include('view/header.php');
if($vue == 'connexion'){
    include('view/connexion.php');
}
if($vue == 'administrateurConnecte'){
    include('view/administrateurConnecte.php');
}
if($vue == 'lesStats'){
    include('view/LesStats.php');
}
if($vue == 'historiqueAdmin'){
    include('view/historiqueAdmin.php');
}
if($vue == 'derniereStatsAdmin'){
    include('view/derniereStatsAdmin.php');
}
if($vue == 'statsParLoueur'){
    include('view/statsParLoueur.php');
}
if($vue == 'administration'){
    include('view/administration.php');
}
if($vue == 'creerLoueur'){
    include('view/creationLoueur.php');
}
if($vue == 'modifierLoueur'){
    include('view/modifLoueur.php');
}
if($vue == 'supprimerLoueur'){
    include('view/supprLoueur.php');
}
if($vue == "utilisateurConnecte") {
    include('view/loueurConnecte.php');
}
if($vue == "historiqueLoueur") {
    include('view/historiqueLoueur.php');
}
if($vue == "derniereStatsLoueur") {
    include('view/derniereStatsLoueur.php');
}
if($vue == "mesInfos") {
    include('view/mesInformations.php');
}
include('view/footer.php');