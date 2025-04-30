<!DOCTYPE html>
<html>

<head>

    <!-- En-tête du document Si avec l'UTF8 cela ne fonctionne pas mettez charset=ISO-8859-1 -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <title>Formulaire de saisie d'une variété d'un produit</title>
    <link rel="stylesheet" href="style/style.css" />
    <link rel="stylesheet" href="style/connection.css" />
</head>

<body>
    <h1>Formulaire correspondant à une variété d'un produit</h1>

    <form action="ajouter_variete.php" method=" POST">
        <div class="form-group">
            <label for="nom">Nom de la variété:</label>
            <input type="text" name="nom" size="40" />
        </div>
        <?php echo '<input type="hidden" name="article" value="' . $_GET["article"] . '"/>'; ?>
        <div class="form-group">
            <label for="nom">Nom de la variété:</label>
            <input type="text" name="nom" size="40" />
        </div>
        Calibre: <input type="number" name="calibre" min="1" /><br />
        Quantité en stock: <input type="number" name="q_stock" min="1" /><br />
        </p>
        <p>
            <input type="reset" name="reset" value="Effacez" />
            <input type="submit" name="submit" value="Validez" />
        </p>
    </form>
    <?php
    include ("connexion.inc.php");
    if (isset($_POST['submit'])) {
        if (empty($_POST['nom']) && empty($_POST['article']) && empty($_POST['calibre']) && empty($_POST['q_stock'])) {
            echo "Merci de passer par le formulaire ajouter_variété.php<br />";
            echo '<a href = "ajouter_variete.php"> aller au formulaire ajouter_variete</a>';
        } else {
            $nom = $_POST['nom'];
            $article = $_POST['article'];
            $calibre = $_POST['calibre'];
            $stock = $_POST['q_stock'];
            if (empty($nom) && empty($article) && empty($calibre) && empty($stock)) {
                echo "Valeur vide";
            } else {
                $cnx->exec("SET search_path to sae;");
                $code = substr($_GET["article"], 2) . substr($nom, 2) . $calibre . '01';
                $requete = "INSERT into variete Values('$code','$calibre','$nom','$stock','" . $_GET["article"] . "')";
                $num = $cnx->exec($requete);
                echo "Les informations('$code','$calibre','$nom','$stock','" . $_GET["article"] . "') ont  bien été ajouté.";
                echo '<a href = "produit.php?"' . $_GET["article"] . '"> retourner à la page produit</a>';
            }
        }
    }
    ?>
</body>

</html>