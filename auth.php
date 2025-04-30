<?php
function panier()
{
    /* Initialisation du panier */
    if (empty($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
        /* Subdivision du panier */
        $_SESSION['panier']['article'] = array();
        $_SESSION['panier']['variete'] = array();
        $_SESSION['panier']['qte'] = array();
        $_SESSION['panier']['calibre'] = array();
        $_SESSION['panier']['prix'] = array();
    }
}


session_start();
include ("connexion.inc.php");
$pseudo = $_POST['username'];
$mdp = $_POST['password'];
// on regarde si c'est un client
$results = $cnx->query("SELECT nomclt, mot_de_passe FROM sae.client");
while ($ligne = $results->fetch(PDO::FETCH_OBJ)) // un par un
{
    if ($ligne->nomclt == $pseudo && password_verify($mdp, $ligne->mot_de_passe)) {
        echo "Authentification réussie";
        $_SESSION['login'] = $pseudo;
        $_SESSION['permission'] = 2;
        panier();
        header('location: index.php');
        exit;
    }
}
$results->closeCursor();

// on regarde si c'est un employer de la societe
$result = $cnx->query("SELECT * FROM sae.employe");
while ($lign = $result->fetch(PDO::FETCH_OBJ)) // un par un
{
    if (($lign->prenom . ' ' . $lign->nom) == $pseudo && password_verify($mdp, $lign->mot_de_passe)) {
        echo "Authentification réussie";
        $_SESSION['login'] = $pseudo;
        if ($lign->fonction == 'Directeur') {
            $_SESSION['permission'] = 4;
        } else {
            $_SESSION['permission'] = 3;
        }
        panier();
        header('location: index.php');
        exit;
    }
}
$results->closeCursor();
echo "Authentification echouer";
header('location: connection.php');