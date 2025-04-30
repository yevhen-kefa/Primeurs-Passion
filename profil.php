<?php
session_start();
if (isset($_SESSION['login']) && isset($_SESSION['permission'])) {
    $ok = true;
} else {
    $ok = false;
}
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
    include ("header.php");
    ?>

    <main>
        <?php
        // Connection à la base de données
        include("connexion.inc.php");

        $nom = $_SESSION['login'];
        $permission = $_SESSION['permission'];

        if ($permission > 1) {
            // Requête pour récupérer les informations de la personne connectée
            if ($permission == 2) {
                $query = "SELECT * FROM sae.client WHERE nomclt = '$nom'";
            } elseif ($permission == 3 || $permission == 4) {
                $pseudo = explode(" ", $nom);
                $query = "SELECT * FROM sae.employe WHERE prenom = '$pseudo[0]' AND nom = '$pseudo[1]'";
            }

            // Exécution de la requête
            $result = $cnx->query($query);

            // Vérification s'il y a des résultats
            if ($result->rowCount() == 1) {
                $ligne = $result->fetch(PDO::FETCH_OBJ);

                // Début de la section
                echo '<section class="profile-section">';

                // Début du div
                echo '<div class="profile-info-container">';

                // Information de la personne
                if ($permission == 2) {
                    echo '<p class="profile-info"> Nom: ' . $ligne->nomclt . '</p>';
                    echo '<p class="profile-info"> Adresse: ' . $ligne->adresseclt . '</p>';
                    echo '<p class="profile-info"> N° de téléphone: ' . $ligne->telclt . '</p>';
                    echo '<p class="profile-info"> Catégorie de client: ' . $ligne->nomtarif . '</p>';
                } elseif ($permission == 3 || $permission == 4) {
                    echo '<p class="profile-info"> Prénom: ' . $ligne->prenom . '</p>';
                    echo '<p class="profile-info"> Nom: ' . $ligne->nom . '</p>';
                    echo '<p class="profile-info"> Fonction: ' . $ligne->fonction . '</p>';
                    echo '<p class="profile-info"> Date de naissance: ' . $ligne->date_naissance . '</p>';
                    echo '<p class="profile-info"> Type de contrat: ' . $ligne->type_contrat . '</p>';
                }
                // Lien pour modifier le profil
                echo '<a href="edit_profile.php" class="edit-profile-link"><i class="fas fa-pencil-alt"></i> Modifier votre profil</a>';

                // Fermeture du div
                echo '</div>';

                // Fermeture de la section
                echo '</section>';
            }
        } else {
            header('location: connection.php');
        }
        ?>
    </main>

    <?php
        include ("footer.php");
    ?>
    <script src="script/header.js"></script>
</body>

</html>