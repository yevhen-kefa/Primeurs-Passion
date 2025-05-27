<?php
session_start();
require_once "connexion.inc.php";

if (!isset($_SESSION['user_id']) || !isset($_POST['id_variete'], $_POST['action'])) {
    header("Location: panier.php");
    exit;
}

$idClient = $_SESSION['user_id'];
$idVariete = intval($_POST['id_variete']);
$action = $_POST['action'];

if (!in_array($action, ['increase', 'decrease'])) {
    header("Location: panier.php");
    exit;
}

$change = $action === 'increase' ? 1 : -1;

$stmt = $cnx->prepare("UPDATE sae_panier SET quantite = GREATEST(1, quantite + :change) WHERE id_client = :id_client AND id_variete = :id_variete");
$stmt->execute([
    ':change' => $change,
    ':id_client' => $idClient,
    ':id_variete' => $idVariete,
]);

header("Location: panier.php");
exit;
