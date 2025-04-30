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
    <link rel="stylesheet" href="style/panier.css" />
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
        <div class="panier-container">
            <h1>Votre panier</h1>
            <div class="panier-items">
                <table>
                    <tr class="first_lign">
                        <td>Article</td>
                        <td>Variete</td>
                        <td>Quantité</td>
                        <td>Calibre</td>
                        <td>Prix Unitaire</td>
                    </tr>
                    <?php
                    function MontantGlobal()
                    {
                        $total = 0;
                        for ($i = 0; $i < count($_SESSION['panier']['article']); $i++) {
                            $total += $_SESSION['panier']['qte'][$i] * $_SESSION['panier']['prix'][$i];
                        }
                        return $total;
                    }

                    if (isset($_SESSION['panier'])) {
                        $nbArticles = count($_SESSION['panier']['article']);
                        if ($nbArticles <= 0)
                            echo "<tr><td colspan=\"5\">Votre panier est vide </ td></tr>";
                        else {
                            for ($i = 0; $i < $nbArticles; $i++) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($_SESSION['panier']['article'][$i]) . "</ td>";
                                echo "<td>" . htmlspecialchars($_SESSION['panier']['variete'][$i]) . "</td>";
                                echo "<td>" . htmlspecialchars($_SESSION['panier']['qte'][$i]) . "</td>";
                                echo "<td>" . htmlspecialchars($_SESSION['panier']['calibre'][$i]) . "</td>";
                                echo "<td>" . htmlspecialchars($_SESSION['panier']['prix'][$i]) . "</td>";
                                echo "<td>" . '<a href =\'supprim_panier.php?variete=' . $_SESSION['panier']['variete'][$i] . '\'> Supprimer</a></td>';
                                echo "</tr><br>";
                            }

                            echo "<tr>";
                            echo "<td colspan=\"5\">";
                            echo "Total : " . MontantGlobal();
                            echo "</td></tr>";

                            echo "<tr><td colspan=\"5\">";
                            echo "<input type=\"submit\" value=\"Rafraichir\"/>";
                            echo "<input type=\"hidden\" name=\"action\" value=\"refresh\"/>";

                            echo "</td></tr>";
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </main>

    <?php
    include ("footer.php");
    ?>

    <script src="script/header.js"></script>
</body>

</html>

<!-- content : $2y$10$IXww9T0pzLvMV.QfC7kS0u6586/hdczpDabqpymE5aZ9wEbSKHMES -->
<!-- tresconcentrer : $2y$10$pJaBfAxT.WGBc9l0AuyIm.mLS4bqp//wkmyxNTfAwW8UEqAQb7mtu -->
<!-- fatiguer : $2y$10$G5heT9i7Ik24vsvVG0aLneGkZvY.VWbUpKoa7Yq559leYEWBHyuA. -->
<!-- confus : $2y$10$6PvIRJ8M4c4IFh3VHjWnpOqx4t6ApiWa/gEVgUDS4BnmrEE3OqTDG -->