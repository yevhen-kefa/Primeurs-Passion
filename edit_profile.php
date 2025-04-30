<?php
session_start();
$ok = false;
if (isset($_SESSION['login']) && isset($_SESSION['permission'])) {
    $ok = true;
} else {
    $_SESSION['permission'] = 1;
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['login'])) {
    header('Location: connection.php');
    exit();
}

// Inclure le fichier de connexion à la base de données
include("connexion.inc.php");

// Récupérer les informations de l'utilisateur
$pseudo = $_SESSION['login'];
$query = "SELECT * FROM sae.client WHERE nomclt = :pseudo";
$statement = $cnx->prepare($query);
$statement->bindParam(':pseudo', $pseudo);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="style/style.css" />
    <link rel="stylesheet" href="style/header.css" />
    <link rel="stylesheet" href="style/footer.css" />
    <link rel="stylesheet" href="style/profil.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <!-- logo -->
    <link rel="icon" href="img/icon/logo-transparent-png.png" />
    <title>Primeurs - Passions</title>
</head>

<body>
    <?php
        include("header.php");
    ?>
    <section class="profile-section">
        <div class="profile-form-container">
            <h2 class="form-title">Modifier votre profil</h2>
            <form action="update_profile.php" method="POST" class="profile-form">
                <label for="nom" class="form-label">Nom:</label>
                <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($user['nomclt']); ?>"
                    class="form-input" required><br>

                <label for="adresse" class="form-label">Adresse:</label>
                <input type="text" id="adresse" name="adresse"
                    value="<?php echo htmlspecialchars($user['adresseclt']); ?>" class="form-input" required><br>

                <label for="telephone" class="form-label">Téléphone:</label>
                <input type="text" id="telephone" name="telephone"
                    value="<?php echo htmlspecialchars($user['telclt']); ?>" class="form-input" required><br>

                <!-- Ajoutez d'autres champs de formulaire selon vos besoins -->

                <input type="submit" value="Enregistrer les modifications" class="submit-btn">
                <a href="profil.php"><input type="button" value="Annuler" class="cancel-btn"></a>
            </form>
        </div>
    </section>

    <?php
        include("footer.php");
    ?>

    <script src="script/header.js"></script>
    <script src="script/produitindex.js"></script>

</body>

</html>