<?php
session_start();
require_once "connexion.inc.php";

if (!isset($_SESSION['user_id'], $_POST['id_variete'])) {
    header("Location: panier.php");
    exit;
}

$idClient = $_SESSION['user_id'];
$idVariete = intval($_POST['id_variete']);

$stmt = $cnx->prepare("DELETE FROM sae_panier WHERE id_client = :id_client AND id_variete = :id_variete");
$stmt->execute([
    ':id_client' => $idClient,
    ':id_variete' => $idVariete,
]);

header("Location: panier.php");
exit;
