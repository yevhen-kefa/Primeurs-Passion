<?php
include ("connexion.inc.php");

$nom = $_POST["nomc"];

$query = "INSERT INTO sae.categoriefruit Values $nom";

$result = $cnx->exec($query);

?>