<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "connexion.inc.php";

if (!isset($cnx)) {
    die("Connexion à la base de données non établie.");
}
$isAdmin = $_SESSION['is_admin'] ?? false;

$category = $_GET['cat'] ?? null;

if (!$category) {
    echo "<p>Catégorie invalide.</p>";
    exit;
}


$stmt = $cnx->prepare("SELECT * FROM SAE_Client WHERE id_client = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();

$stmtCat = $cnx->prepare("SELECT id_article FROM sae_article WHERE categorie = :cat");
$stmtCat->execute([':cat' => $category]);
$idArticle = $stmtCat->fetchColumn();



if (!$idArticle) {
    echo "<p>Catégorie non trouvée.</p>";
    exit;
}

$stmtItems = $cnx->prepare("
    SELECT nom, prix 
    FROM sae_variete 
    WHERE id_article = :id_article
");
$stmtItems->execute([':id_article' => $idArticle]);
$items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Votre Panier</title>
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background: #dff8f0;
        }


        header {
            background-color: #c4e3c5;
            padding: 10px;
            display: flex;
            justify-content: center;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            width: 100%;
            background: #bfe3c7;
            padding: 12px 16px;
        }

        .hamburger-menu {
            z-index: 1000;
        }

        .menu-btn {
            font-size: 24px;
            cursor: pointer;
            display: block;
        }


        #menu-toggle {
            display: none;
        }


        .sidebar {
            position: fixed;
            top: 0;
            left: clamp(-150px, -15vw, -100vw);
            width: clamp(300px, 30vw, 200vw);
            height: 100%;
            background-color: #41553F;
            color: white;
            overflow-y: auto;
            padding: 1rem;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease;
            transform: translateX(-1000%);
        }


        #menu-toggle:checked+.menu-btn+.sidebar {
            transform: translateX(0);
        }


        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar li {
            margin: 15px 0;
            text-align: center;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
        }

        .sidebar a:hover {
            text-decoration: underline;
        }

        .close-btn {
            font-size: 24px;
            cursor: pointer;
            display: block;
            text-align: right;
            margin-bottom: 20px;
            color: white;
            /* au cas où le fond serait foncé */
        }

        .logo {
            font-weight: bold;
            text-align: center;
            font-size: 18px;
        }

        .search-bar {
            flex-grow: 1;
            margin: 0 20px;
            padding: 5px;
            border-radius: 10px;
            border: 1px solid #ccc;
        }

        .icons span {
            margin-left: 15px;
        }

        main {
            padding: 20px;
        }

        h2 {
            font-size: 24px;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
        }

        .cart {
            margin-top: 20px;
        }

        .item {
            background-color: #b2e3c0;
            display: flex;
            align-items: center;
            width: 30%;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
        }

        .item img {
            width: 60px;
            height: 60px;
            margin-right: 10px;
        }

        .details {
            flex-grow: 1;
        }

        .quantity {
            display: flex;
            align-items: center;
            margin: 0 10px;
        }

        .quantity button {
            background-color: white;
            border: 1px solid #999;
            padding: 5px 10px;
            cursor: pointer;
        }

        .quantity span {
            margin: 0 5px;
        }

        .delete {
            background-color: #ff8080;
            border: none;
            padding: 5px 10px;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        footer {
            background: #222;
            color: #fff;
            padding: 20px;
        }

        .footer-info {
            display: flex;
            justify-content: space-around;
            flex-wrap: nowrap;
        }

        .footer-info h3,
        .footer-info h4 {
            margin-top: 0;
        }

        .contacts {
            display: flex;
            justify-content: space-around;
            flex-wrap: nowrap;
            gap: 2rem;
        }

        .about {
            max-width: 300px;
        }

        .contacts>div {
            margin: 10px;
        }

        footer .copyright {
            text-align: center;
            padding-top: 10px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <header>
        <div class="topbar">
            <div class="hamburger-menu">
                <input type="checkbox" id="menu-toggle">
                <label for="menu-toggle" class="menu-btn">☰</label>

                <div class="sidebar">
                    <label for="menu-toggle" class="close-btn">✕</label>
                    <ul>
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="categorie.php">Catégories</a></li>
                        <li><a href="panier.php">Panier</a></li>
                        <?php if ($isAdmin) : ?>
                        <li><a href="page_admin.php">Page admin</a></li>
                        <?php endif; ?>
                        <li><a href="deconnexion.php">Deconnexion</a></li>
                    </ul>
                </div>
            </div>
            <div class="logo">🍓 PRIMEURS-PASSION<br><small>Vos produits à votre porte</small></div>
            <input type="text" placeholder="Recherche..." class="search-bar" />
              <div class="icons">
                <?php if (isset($_SESSION['user_id']) && isset($user)): ?>
                    <a href="profil.php"><span>👤 <?= htmlspecialchars($user['nom']) ?></span></a>
                <?php else: ?>
                    <a href="login.php"><span>👤 Login</span></a>
                <?php endif; ?>
                <a href="panier.php"><span>🛒 Panier</span></a>
            </div>
        </div>
    </header>

 <?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_GET['cat']) || empty($_GET['cat'])) {
    echo "<p>Категорія не вибрана.</p>";
    exit;
}

$selectedCategory = $_GET['cat'];

try {
    $stmt = $cnx->prepare("SELECT id_article FROM SAE_Article WHERE categorie = :categorie LIMIT 1");
    $stmt->execute(['categorie' => $selectedCategory]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$article) {
        echo "<p>Категорія \"" . htmlspecialchars($selectedCategory) . "\" не знайдена.</p>";
        exit;
    }

    $id_article = $article['id_article'];

    // Вибираємо товари для цієї категорії
    $stmt_var = $cnx->prepare("SELECT * FROM SAE_Variete WHERE id_article = :id_article");
    $stmt_var->execute(['id_article' => $id_article]);
    $products = $stmt_var->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Помилка при виборі даних: " . htmlspecialchars($e->getMessage());
    exit;
}
?>

  <main>
    <h2><?= htmlspecialchars($selectedCategory) ?></h2>
    <hr>

    <?php if (count($products) === 0): ?>
        <p>Aucun produit trouvé pour cette catégorie.</p>
    <?php else: ?>
        <div class="cart">
            <?php foreach ($products as $product): ?>
                <div class="item">
                    <img src="img_pp/Tomate.jpg" alt="<?= htmlspecialchars($product['nom']) ?>" />
                    <div class="details">
                        <h3><?= htmlspecialchars($product['nom']) ?></h3>
                        <p 
                            class="panier btn-add-cart" 
                            data-variete-id="<?= htmlspecialchars($product['id_variete']) ?>"
                            style="cursor:pointer;"
                        >
                        <?= !empty($product['in_cart']) ? 'dans panier' : '+ au panier' ?>
                        </p>
                        <p>Prix: <?= number_format($product['prix'], 2) ?> €</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>



    <footer>
        <div class="footer-info">
            <div class="about">
                <h3>À propos</h3>
                <p>Primeurs-Passion une entreprise locale qui se consacre à la production de produits bio et
                    locaux.<br>
                    Nous proposons des produits frais et de qualité</p>
            </div>
            <div class="contacts">
                <div>
                    <h4>Contact</h4>
                    <p>KEFA Yevhen<br>Adresse : 123, Rue, Ville, Pays<br>Email : contact@exemple.com<br>Téléphone :
                        +123
                        456 7890</p>
                </div>
                <div>
                    <h4>Contact</h4>
                    <p>MUSY Loane<br>Adresse : 123, Rue, Ville, Pays<br>Email : contact@exemple.com<br>Téléphone :
                        +123
                        456 7890</p>
                </div>
                <div>
                    <h4>Contact</h4>
                    <p>PERES Yanis<br>Adresse : 123, Rue, Ville, Pays<br>Email : contact@exemple.com<br>Téléphone :
                        +123
                        456 7890</p>
                </div>
            </div>
        </div>
        <div class="copyright">© 2025 Primeurs-Passion. Tous droits réservés.</div>
    </footer>

</body>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const panierButtons = document.querySelectorAll('.btn-add-cart');

    panierButtons.forEach(button => {
        button.addEventListener('click', function () {
            const varieteId = this.dataset.varieteId;

            fetch('add_to_panier.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id_variete=' + encodeURIComponent(varieteId)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.textContent = 'dans panier';
                } else {
                    alert(data.message || 'Erreur lors de l\'ajout au panier');
                }
            })
            .catch(error => {
                console.error('Erreur AJAX:', error);
            });
        });
    });
});
</script>
</html>