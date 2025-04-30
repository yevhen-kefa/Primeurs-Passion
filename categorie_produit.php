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
    <link rel="stylesheet" href="style/categorie_produit.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <!-- logo -->
    <link rel="icon" href="img/icon/logo-transparent-png.png" />
    <title>Primeurs - Passions</title>
</head>

<body>
    <?php
    include("header.php");
    ?>
    <main>

        <?php
        function article($result, $count)
        {
            if ($result->rowCount() > 0) {

                // Début de la table
                echo '<table class="table-section">';

                // Parcourir les lignes de résultats
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    // Vérifier si le compteur est pair
                    if ($count % 2 == 0) {
                        // Si pair, commencer une nouvelle ligne de tableau
                        echo '<tr>';
                    }

                    // Commencer une nouvelle cellule de tableau
                    echo '<td>';

                    // Début de la balise a avec la classe et l'ID
                    echo '<a href="produit.php?article=' . $row["noma"] . '"' . 'class="categorie-link" id="' . $row['noma'] . '">';

                    // Début de la section avec la classe correspondant au nom de la catégorie
                    echo '<section class="section ' . strtolower(str_replace(' ', '-', $row['noma'])) . '">';

                    // Le titre de la section est le nom de la catégorie
                    echo '<h4>' . $row['noma'] . '</h4>';

                    // Description générique pour chaque catégorie de fruit
                    echo '<p>Des fruits de qualité pour une collation saine et délicieuse.</p>';

                    // Fermeture de la section
                    echo '</section>';

                    // Fermeture de la balise a
                    echo '</a>';

                    // Fermeture de la cellule de tableau
                    echo '</td>';

                    // Incrémenter le compteur
                    $count++;

                    // Vérifier si le compteur est impair ou si c'est la dernière catégorie
                    if ($count % 2 != 0 || $count == $result->rowCount()) {
                        // Si impair ou dernière catégorie, fermer la ligne de tableau
                        echo '</tr>';
                    }
                }

                // Fermeture de la table
                echo '</table>';

            }
        }

        ?>
        <?php
        // Connection à la base de données
        include ("connexion.inc.php");



        $query = "SELECT Distinct(nomc) FROM sae.articles";
        if (isset($_GET["categorie_article"])) {
            $categorie = $_GET["categorie_article"];
            $query = "SELECT * FROM sae.articles where nomc= '$categorie'";

            $result = $cnx->query($query);
            $count = 0;
            article($result, $count);
        } else {
            $result = $cnx->query($query);
            if ($result->rowCount() > 0) {
                // Parcourir les lignes de résultats
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $nom = $row["nomc"];

                    echo '<a href="categorie_produit.php?categorie_article=' . $nom . '"' . 'class="categorie-link" id="' . $nom . '">';
                    echo $nom . '</a>';

                    $result1 = $cnx->query("SELECT * FROM sae.articles where nomc= '$nom'");
                    $count = 0;
                    article($result1, $count);
                }
            }
        }
        ?>

        <?php
        if (empty($_GET["categorie_article"]) && $_SESSION['permission'] > 2) {
            echo '<form method="POST" action="ajouter.php">';
            echo '<label for="nomc">Nom de la categorie de produit à ajouter </label>';
            echo '<input type="text" name="nomc"/>';
            echo '<input type="submit" name="ajout" value="Ajouter" />';
            echo '</form>';
        }
        ?>
    </main>
    <?php
        include ("footer.php");
    ?>

    <script src="script/header.js"></script>
    <script src="script/produit.js"></script>
    <script src="script/script.js"></script>
</body>

</html>