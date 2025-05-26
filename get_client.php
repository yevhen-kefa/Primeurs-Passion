<?php
require_once 'connexion.inc.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $cnx->prepare("SELECT * FROM SAE_Client WHERE id_client = ?");
    $stmt->execute([$id]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($client);
}
?>