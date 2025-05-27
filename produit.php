<?php
require_once 'connexion.inc.php'; 

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_product'])) {
    $nom = $_POST['nom'];
    $calibre = $_POST['calibre'];
    $prix = $_POST['prix'] !== '' ? (int)$_POST['prix'] : null;
    $id_article = $_POST['id_article']; 
    $code_variete = 'P' . strtoupper(mb_substr($nom, 0, 3));

    try {
        $stmt = $cnx->prepare("
            INSERT INTO sae_variete (code_variete, nom, calibre, prix, id_article)
            VALUES (:code_variete, :nom, :calibre, :prix, :id_article)
            RETURNING id_variete
        ");
        $stmt->execute([
            ':code_variete' => $code_variete,
            ':nom' => $nom,
            ':calibre' => $calibre,
            ':prix' => $prix,
            ':id_article' => $id_article
        ]);
        $successMessage = "Produit ajouté avec succès.";
    } catch (PDOException $e) {
        $errorMessage = "Erreur lors de l'ajout: " . $e->getMessage();
    }
}

//Update product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $id_variete = $_POST['product_id'];
    $nom = $_POST['nom'];
    $calibre = $_POST['calibre'];
    $prix = $_POST['prix'] !== '' ? (int)$_POST['prix'] : null;
    $id_article = $_POST['id_article'];

    try {
        $stmt = $cnx->prepare("
            UPDATE sae_variete
            SET nom = :nom, calibre = :calibre, prix = :prix, id_article = :id_article
            WHERE id_variete = :id_variete
        ");
        $stmt->execute([
            ':nom' => $nom,
            ':calibre' => $calibre,
            ':prix' => $prix,
            ':id_article' => $id_article,
            ':id_variete' => $id_variete
        ]);
        $successMessage = "Produit mis à jour avec succès.";
    } catch (PDOException $e) {
        $errorMessage = "Erreur lors de la mise à jour: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id_variete = (int)$_GET['id'];
    $stmt = $cnx->prepare("
        SELECT id_variete, nom, calibre, prix, id_article FROM sae_variete WHERE id_variete = :id_variete
    ");
    $stmt->execute([':id_variete' => $id_variete]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    if ($produit === false) {
    http_response_code(404);
    echo json_encode(['error' => 'Produit non trouvé']);
    exit;
}
header('Content-Type: application/json');
echo json_encode($produit);
exit;
}
?>
