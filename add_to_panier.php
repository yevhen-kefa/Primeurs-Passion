<?php
session_start();
require_once "connexion.inc.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Non connecté']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_variete'])) {
    $idClient = $_SESSION['user_id'];
    $idVariete = intval($_POST['id_variete']);
    $quantite = 1;

    try {
        $stmt = $cnx->prepare("SELECT quantite FROM sae_panier WHERE id_client = :id_client AND id_variete = :id_variete");
        $stmt->execute([':id_client' => $idClient, ':id_variete' => $idVariete]);
        $existing = $stmt->fetch();

        if ($existing) {
            $newQuantity = $existing['quantite'] + $quantite;
            $stmtUpdate = $cnx->prepare("UPDATE sae_panier SET quantite = :quantite WHERE id_client = :id_client AND id_variete = :id_variete");
            $stmtUpdate->execute([':quantite' => $newQuantity, ':id_client' => $idClient, ':id_variete' => $idVariete]);
        } else {
            $stmtInsert = $cnx->prepare("INSERT INTO sae_panier (id_client, id_variete, quantite) VALUES (:id_client, :id_variete, :quantite)");
            $stmtInsert->execute([':id_client' => $idClient, ':id_variete' => $idVariete, ':quantite' => $quantite]);
        }

        echo json_encode(['success' => true]);
        exit;
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        exit;
    }
}

echo json_encode(['success' => false, 'message' => 'Requête invalide']);
exit;
