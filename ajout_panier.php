<?php
session_start();
include ("connexion.inc.php");
function ajouterArticle($article, $variete, $qte, $prix, $calibre)
{

    //Si le panier existe
    if (isset($_SESSION['panier'])) {
        //Si le produit existe déjà on ajoute seulement la quantité
        $positionProduit = array_search($variete, $_SESSION['panier']['variete']);

        if ($positionProduit !== false) {
            $_SESSION['panier']['qte'][$positionProduit] += $qte;
        } else {
            //Sinon on ajoute le produit
            array_push($_SESSION['panier']['article'], $article);
            array_push($_SESSION['panier']['variete'], $variete);
            array_push($_SESSION['panier']['qte'], $qte);
            array_push($_SESSION['panier']['calibre'], $calibre);
            array_push($_SESSION['panier']['prix'], $prix);
        }
    } else
        echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}
if (isset($_POST["article"]) && isset($_POST["variete"]) && isset($_POST["calibre"]) && isset($_POST["prix"]) && isset($_POST["quantite"])) {
    ajouterArticle($_POST["article"], $_POST["variete"], $_POST["quantite"], $_POST["prix"], $_POST["calibre"]);

    header('location: panier.php');
}