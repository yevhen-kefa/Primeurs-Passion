<?php
session_start();
require_once "connexion.inc.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$idClient = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acheter'])) {
    try {
        $cnx->beginTransaction();

        $stmtCommande = $cnx->prepare("
            INSERT INTO sae_commandes (id_client, date_commande) 
            VALUES (:id_client, CURRENT_TIMESTAMP)
            RETURNING id_commandes
        ");
        $stmtCommande->execute([':id_client' => $idClient]);
        $idCommande = $stmtCommande->fetchColumn();

        if (!$idCommande) {
            throw new Exception("Erreur lors de la création de la commande.");
        }

        $stmtPanier = $cnx->prepare("SELECT id_variete, quantite FROM sae_panier WHERE id_client = :id_client");
        $stmtPanier->execute([':id_client' => $idClient]);
        $panierItems = $stmtPanier->fetchAll(PDO::FETCH_ASSOC);

        if (count($panierItems) === 0) {
            throw new Exception("Le panier est vide.");
        }

        $stmtInsertItem = $cnx->prepare("
            INSERT INTO sae_commande_items (id_commande, id_variete, quantite) 
            VALUES (:id_commande, :id_variete, :quantite)
        ");

        foreach ($panierItems as $item) {
            $stmtInsertItem->execute([
                ':id_commande' => $idCommande,
                ':id_variete' => $item['id_variete'],
                ':quantite' => $item['quantite']
            ]);
        }

        $stmtDeletePanier = $cnx->prepare("DELETE FROM sae_panier WHERE id_client = :id_client");
        $stmtDeletePanier->execute([':id_client' => $idClient]);

        $cnx->commit();

        header("Location: panier.php?success=1");
        exit;

    } catch (Exception $e) {
        $cnx->rollBack();
        echo "Erreur lors du traitement de la commande : " . htmlspecialchars($e->getMessage());
        exit;
    }
} else {
    header("Location: panier.php");
    exit;
}
