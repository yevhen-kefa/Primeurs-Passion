<?php
include ("connexion.inc.php");

// Récupération des données du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$adresse = $_POST['adresse'];
$telephone = $_POST['telephone'];
$metier = $_POST['metier'];
$passwordsimple = $_POST['password'];
$grain = 'Juecy6y0k9U';
$password = password_hash($password, $grain);
// Génération du nom du client (prenom + nom)
$nomclt = $prenom . ' ' . $nom;

// Génération du code client (C + trois premières lettres du nom et prénom)
$codeclt = 'C' . strtoupper(substr($nom, 0, 3)) . strtoupper(substr($prenom, 0, 3));

// Requête d'insertion dans la table client
$query = "INSERT INTO sae.client (codeclt, nomclt, adresseclt, telclt, nomtarif, mot_de_passe) 
          VALUES (:codeclt, :nomclt, :adresse, :telephone, :metier, :password)";

// Préparation de la requête
$statement = $cnx->prepare($query);

// Liaison des paramètres
$statement->bindParam(':codeclt', $codeclt);
$statement->bindParam(':nomclt', $nomclt);
$statement->bindParam(':adresse', $adresse);
$statement->bindParam(':telephone', $telephone);
$statement->bindParam(':metier', $metier);
$statement->bindParam(':password', $password);

// Exécution de la requête
if ($statement->execute()) {
    echo "<script>alert('Inscription réussie avec succès!');window.location.href='index.php';</script>";
    header('Location: connection.php');
} else {
    echo "Erreur lors de l'enregistrement.";
    header('Location: inscription.php');
}
?>