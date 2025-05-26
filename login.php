<?php

require_once "connexion.inc.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['em'] ?? '';
    $pass = $_POST['pass'] ?? '';

    $stmt = $cnx->prepare("SELECT * FROM SAE_Client WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($pass, $user['pass'])) {
        session_start();
        $_SESSION['user_id'] = $user['id_client']; 
        $_SESSION['is_admin'] = $user['is_admin']; 
        header("Location: index.php");
        exit;
    } else {
        $error = "Identifiant ou mot de passe incorrect.";
    }
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
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
            <h1>Connexion</h1>
            <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <form method="post" action="">
                <label for="em">Identifiant :</label>
                <input type="email" id="em" name="em" placeholder="vous@exemple.com" required>

                <label for="pass">Mot de Passe :</label>
                <input type="password" id="pass" name="pass" placeholder="Entrez votre mot de passe" required>

                <button type="submit">Connexion</button>
            </form>
            <p>Vous souhaitez créer un compte ? <a href="register.php"> Inscrivez vous</a> </p>
        </div>
    </div>
</body>
</html>
