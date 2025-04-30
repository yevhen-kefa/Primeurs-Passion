<?php
    $ok = false;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="style/style.css" />
    <link rel="stylesheet" href="style/header.css" />
    <link rel="stylesheet" href="style/footer.css" />
    <link rel="stylesheet" href="style/inscription.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <!-- logo -->
    <link rel="icon" href="img/icon/logo-transparent-png.png" />
    <title>Primeurs - Passions</title>
</head>

<body>
    <?php
        include ("header.php");
    ?>
    <!-- main (contenu de la page) -->
    <main class="content">
        <div class="container-left">
            <h3>primeurs-Passion</h3>
            <img src="img/primeur.webp" alt="primeur" />
            <p>
                Chez Primeurs-Passion, nous nous engageons à fournir à nos
                clients des fruits et légumes de la plus haute qualité,
                cultivés avec soin et amour par nos producteurs locaux.
            </p>

            <p>
                Découvrez notre sélection exceptionnelle de produits et
                laissez-vous séduire par des saveurs authentiques et des
                ingrédients de premier choix.
            </p>
        </div>
        <div class="container-right">
            <div class="login-form">
                <h2>Inscription</h2>

                <form action="inscription-bdd.php" method="POST">
                    <!-- endroit qui va afficher de facon automatique 
                        le codeclt composer de "C" + 3premierers lettres de nom 
                        et trois premiers lettres du prenom -->

                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" required />
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" required />
                    </div>

                    <div class="form-group">
                        <label for="adresse">Adresse</label>
                        <input type="text" id="adresse" name="adresse" required />
                    </div>
                    <div class="form-group">
                        <label for="telephone">Telephone</label>
                        <input type="text" id="telephone" name="telephone" required />
                    </div>
                    <div class="form-group">
                        <label for="metier">Metier</label>
                        <select id="metier" name="metier">
                            <option value="" selected="selected">-- Metier --</option>
                            <?php
                            include ("connexion.inc.php");
                            $results = $cnx->query("SELECT * FROM sae.categorieclient");
                            while ($row = $results->fetch(PDO::FETCH_OBJ)) {
                                echo "<option value=\"$row->nomtarif\">$row->nomtarif</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" required />
                    </div>
                    <button type="submit">S'inscrire</button>
                </form>
                <p class="signup-link">
                    Déjà inscrit ?
                    <a href="connection.php">Connectez-vous ici</a>
                </p>
                <div class="separator">ou</div>
                <div class="google">
                    <a href="#">
                        <img src="img/icon/google-PNG.png" alt="Google" class="icon-google" />
                        <p>Se connecter avec Google</p>
                    </a>
                </div>
            </div>
        </div>
    </main>
    <!-- footer -->
    <?php
        include ("footer.php");
    ?>
    <script src="script/header.js"></script>
</body>

</html>