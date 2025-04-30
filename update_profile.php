<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('Location: connection.php');
    exit();
}

include("connexion.inc.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];

    // Mettre à jour les informations du profil dans la base de données
    $pseudo = $_SESSION['login'];
    $query = "UPDATE sae.client SET nomclt = :nom, adresseclt = :adresse, telclt = :telephone WHERE nomclt = :pseudo";
    $statement = $cnx->prepare($query);
    $statement->bindParam(':nom', $nom);
    $statement->bindParam(':adresse', $adresse);
    $statement->bindParam(':telephone', $telephone);
    $statement->bindParam(':pseudo', $pseudo);

    if ($statement->execute()) {
        echo "Profil mis à jour avec succès.";
        header('Location: profil.php');
    } else {
        echo "Erreur lors de la mise à jour du profil.";
    }
}
?>