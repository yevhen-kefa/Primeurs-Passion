<?php

require_once "connexion.inc.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['pass'] ?? '';
    $adresse = trim($_POST['adress'] ?? '');


    $codeClient = 'C' 
    . strtoupper(mb_substr($nom, 0, 3)) 
    . strtoupper(mb_substr($prenom, 0, 3));


    $stmt = $cnx->prepare("SELECT id_client FROM SAE_Client WHERE email = :email");
    $stmt->execute(['email' => $email]);

    if ($stmt->fetch()) {
        $message = "Un utilisateur avec cet email existe déjà.";
    } else {
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);


        $categorie_client = 2;
        $stmt = $cnx->prepare("
            INSERT INTO SAE_Client (code_client, nom, prenom, tel, email, pass, is_admin, adresse, categorie_client)
            VALUES (:code_client, :nom, :prenom, :tel, :email, :pass, FALSE, :adresse, :categorie_client)
        ");
            
        $stmt->execute([
            'code_client' => $codeClient,
            'nom' => $nom,
            'prenom' => $prenom,
            'tel' => $telephone,
            'email' => $email,
            'pass' => $hashedPass,
            'adresse' => $adresse,
            'categorie_client' => $categorie_client
        ]);


        header("Location: login.php");
        exit;
    }
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="container">
       <div class="illustration">
            <img src="img_pp/log.png" alt="Illustration de personnes âgées">
            <p>Chez Primeurs-Passion, nous nous engageons à fournir à nos clients des fruits et légumes de la plus haute qualité, cultivés avec soin et amour par nos producteurs locaux.</p>
            <p> Découvrez notre sélection exceptionnelle de produits et laissez-vous séduire par des saveurs authentiques et des ingrédients de premier choix.</p>
        </div>
    <div class="login-form">
        <h1>Inscription</h1>
        <?php if (!empty($message)) echo "<p style='color:red;'>$message</p>"; ?>
        <form method="post" action="">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" placeholder="Nom" required />

            <label for="prenom">Prenom:</label>
            <input type="text" id="prenom" name="prenom" placeholder="Prenom" required />

            <label for="telephone">Téléphone :</label>
            <input type="tel" id="telephone" name="telephone" placeholder="+33600047079" required />

            <label for="adress">Adress :</label>
            <input type="text" id="adress" name="adress" placeholder="adress" required />

            <label for="courriel">Courriel :</label>
            <input type="email" id="courriel" name="email" placeholder="mail@gmail.com" required />

            <label for="pass">Mot de passe :</label>
            <input type="password" id="pass" name="pass" placeholder="Mot de passe" required />

            <button type="submit">Inscription</button>
        </form>
    </div>
</div>
</body>
</html>
