<?php
session_start();
$ok = false;
if (isset($_SESSION['login']) && isset($_SESSION['permission'])) {
    $ok = true;
} else {
    $_SESSION['permission'] = 1;
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
    <link rel="stylesheet" href="style/index.css" />

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
        // Connection à la base de données
        include ("connexion.inc.php");

        // Requête pour récupérer les catégories de fruits
        $query = "SELECT nomc FROM sae.categoriefruit";

        // Exécution de la requête
        $result = $cnx->query($query);

        // Vérification s'il y a des résultats
        if (!is_bool($result) && $result->rowCount() > 0) {
            // Début de la div content
            echo '<div class="content">';

            // Début de la div categorie
            echo '<div class="categorie">';

            // Début de la table
            echo '<table class="table-section">';

            // Initialisation d'un compteur pour organiser les catégories en lignes de deux
            $count = 0;

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
                echo '<a href="categorie_produit.php?categorie_article=' . $row["nomc"] . '"' . 'class="categorie-link" id="' . $row['nomc'] . '">';

                // Début de la section avec la classe correspondant au nom de la catégorie
                echo '<section class="section ' . strtolower(str_replace(' ', '-', $row['nomc'])) . '">';

                // Le titre de la section est le nom de la catégorie
                echo '<h4>' . $row['nomc'] . '</h4>';

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

            // Fermeture de la div categorie
            echo '</div>';

            // Fermeture de la div content
            echo '</div>';
        } else {
            // Aucune catégorie de fruits trouvée
            echo "Aucune catégorie de fruits trouvée.";
        }
        ?>



        <?php
        // Connection à la base de données
        include ("connexion.inc.php");

        // Requête pour récupérer les noms de fruits
        $query = "SELECT noma FROM sae.articles";

        // Exécution de la requête
        $result = $cnx->query($query);

        // Vérification s'il y a des résultats
        if (!is_bool($result) && $result->rowCount() > 0) {
            // Début de la section
            echo '<section class="horizontal-scroll" onwheel="scrollHorizontally(event)">';

            // Initialisation d'un compteur pour organiser les catégories en lignes de deux
            $count = 0;

            // Parcourir les lignes de résultats
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $article = $row["noma"];

                // Vérifier si le compteur est pair
                if ($count % 2 == 0) {
                    // Si pair, commencer une nouvelle ligne de tableau
                    echo '<tr>';
                }

                // Commencer une nouvelle cellule de tableau
                echo '<td>';

                // Début de la balise a avec la classe 
                echo '<a href = "produit.php?article=' . $article . '"' . 'class="product">';

                // image du fruit
                echo '<img src="img/categorie/fruitsec.jpg" alt="Fruit Sec" class="product-image" />';

                // nom du fruit
                echo '<h3 class="product-name">' . $article . '</h3>';


                //SELECT * FROM sae.depend as d where nomtarif =(SELECT nomtarif from sae.client where nomclt ='Abeille Royale') and codev in (SELECT codev from sae.articles as a where noma = 'Poire' and d.codev = a.codev) and id_periode = 1
                if ($_SESSION['permission'] == 2) {
                    $pseudo = $_SESSION['login'];
                    $date = date("Y/m/d");
                    $requete = "SELECT avg(prix) as moyen_prix FROM sae.depend where nomtarif =(SELECT nomtarif from sae.client where nomclt ='$pseudo') and codev in (SELECT codev from sae.variete where noma = '$article') and id_periode in (SELECT id_periode from sae.periode where '$date' between date_debut and date_fin)";
                    $depend = $cnx->query($requete);
                    if (!is_bool($depend) && $depend->rowCount() == 1) {
                        $prix = $depend->fetch(PDO::FETCH_OBJ);
                        if (number_format($prix->moyen_prix, 2) > 0.00) {
                            // Prix pour chaque fruit
                            echo '<p class="product-price">' . number_format($prix->moyen_prix, 2, '.', ',') . '€</p>';
                        } else {
                            echo '<p class="product-price">9.99€</p>';
                        }
                    } else {
                        echo '<p class="product-price">9.99€</p>';
                    }
                }

                // Description générique pour chaque fruit
                // echo '<p class="product-description">
                // Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum, veniam?</p>';
        
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

            // Fermeture de la div 
            echo '</div>';

            // Fermeture de la section
            echo '</section>';
        } else {
            // Aucune catégorie de fruits trouvée
            echo "Aucune catégorie de fruits trouvée.";
        }
        ?>
    </main>
    <?php
        include("footer.php");
    ?>

    <script src="script/header.js"></script>
    <script src="script/produitindex.js"></script>

</body>

</html>