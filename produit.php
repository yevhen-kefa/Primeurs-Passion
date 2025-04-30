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
    <link rel="stylesheet" href="style/produit.css" />

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
        if (isset($_GET["article"])) {
            
            echo '<img src="img/categorie/fruitsec.jpg" alt="Fruit Sec" class="product-image" />';
            
            if (isset($_GET["variete"])) {
                echo '<h2 class="product-title">' . $_GET["article"] . ' (' . $_GET["variete"] . ')</h2>';
            } else {
                echo '<h2 class="product-title">' . $_GET["article"] . '</h2>';
            }

            

            // Description générique du fruit
            echo '<p class="product-description">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum, veniam?</p>';

            //faire un filtre avec les variétés et afficher les info en fonction
            echo '<form method="GET" action="produit.php">';
            echo '<input type="hidden" name="article" value="' . $_GET["article"] . '"/>';
            echo '<select id="variete" name="variete">';
            echo '<option selected="selected">-- Variete --</option>';
            $results = $cnx->query("SELECT * FROM sae.variete where noma='" . $_GET["article"] . "'");
            if (!is_bool($results) && $results->rowCount() > 0) {
                while ($row = $results->fetch(PDO::FETCH_OBJ)) {
                    echo "<option value=\"$row->nomv\">$row->nomv</option>";
                }
            }
            echo '</select>';

            if ($_SESSION['permission'] > 2) {
                echo '<button type="submit" name="submit"">Valider</button>';
                echo '<button type="submit" name="ajouter"">Ajouter une variété</button>';
            } else {
                echo '<button type="submit" name="submit"">Valider</button>';
            }
            echo '</form>';

            if (isset($_GET["submit"])) {
                if (isset($_GET["variete"])) {
                    $variete = $_GET["variete"];
                    $pseudo = $_SESSION['login'];
                    $date = date("Y/m/d");
                    $results = $cnx->query("SELECT * from sae.variete where nomv = '$variete'");
                    if (!is_bool($results) && $results->rowCount() == 1) {
                        $ligne = $results->fetch(PDO::FETCH_OBJ);
                        // on affiche le calibre
                        echo '<p class="product-price"> calibre: ' . $ligne->calibre . '</p>';

                        // on affiche la quantité en stock
                        echo '<p class="product-price"> quantité disponible en stock: ' . $ligne->quantité_stock . '</p>';
                    }
                    // on affiche le prix
                    $results = $cnx->query("SELECT * from sae.depend where nomtarif =(SELECT nomtarif from sae.client where nomclt ='$pseudo') and codev = (select codev from sae.variete where nomv= '$variete') and id_periode = (select id_periode from sae.periode where '$date' between date_debut and date_fin LIMIT 1)");
                    if (!is_bool($results) && $results->rowCount() == 1) {
                        $prix = $results->fetch(PDO::FETCH_OBJ);
                        echo '<p class="product-price"> Prix: ' . $prix->prix . '€</p>';
                        if ($ok) {
                            // faire un bouton pour ajouter au panier(pour les adminitrateur faire un bouton pour leurs permettre de modifer les info)
                            echo '<form action="ajout_panier.php" method="post">';
                            echo '<input type="hidden" name="article" value="' . $_GET["article"] . '"/>';
                            echo '<input type="hidden" name="variete" value="' . $variete . '"/>';
                            echo '<input type="hidden" name="calibre" value="' . $ligne->calibre . '"/>';
                            echo '<input type="hidden" name="prix" value="' . $prix->prix . '"/>';
                            echo '<input type="number" name="quantite" min="1" />Quantité <br />';
                            echo '<button type="submit">Ajouter au panier</button>';
                            echo '</form>';
                        }
                    }

                }
            }
            if (isset($_GET["ajouter"])) {
                header('location: ajouter_variete.php?article="' . $_GET["article"] . '"');
            }
        } else {
            $results = $cnx->query("SELECT noma from sae.articles");
            if (!is_bool($results) && $results->rowCount() > 0) {
                while ($row = $results->fetch(PDO::FETCH_OBJ)) {
                    echo '<a href="produit.php?article=' . $row->noma . '"' . 'class="categorie-link" id="' . $row->noma . '">';
                    echo '<h4>' . $row->noma . '</h4>';
                    echo '</a>';
                }
            }
        }
        ?>
    </main>
    <?php
        include("footer.php");
    ?>

    <script src="script/header.js"></script>
    <script src="script/produit.js"></script>
    <script src="script/script.js"></script>
</body>

</html>