<?php
session_start();
include ("connexion.inc.php");
function suppArticle($variete)
{
    //Si le panier existe
    if (isset($_POST["panier"])) {
        //Nous allons passer par un panier temporaire
        $tmp = array();
        $tmp['article'] = array();
        $tmp['variete'] = array();
        $tmp['qte'] = array();
        $tmp['prix'] = array();
        $tmp['calibre'] = array();


        for ($i = 0; $i < count($_SESSION['panier']['article']); $i++) {
            if ($_SESSION['panier']['article'][$i] !== $variete) {
                array_push($tmp['article'], $_SESSION['panier']['article'][$i]);
                array_push($tmp['variete'], $_SESSION['panier']['variete'][$i]);
                array_push($tmp['qte'], $_SESSION['panier']['qte'][$i]);
                array_push($tmp['prix'], $_SESSION['panier']['prix'][$i]);
                array_push($tmp['calibre'], $_SESSION['panier']['calibre'][$i]);
            }

        }
        //On remplace le panier en session par notre panier temporaire à jour
        $_SESSION['panier'] = $tmp;
        //On efface notre panier temporaire
        unset($tmp);
    } else
        echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}

if (isset($_GET["variete"])) {
    suppArticle($_GET["variete"]);

    header('location: panier.php');
}