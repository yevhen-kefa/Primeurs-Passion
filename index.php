<?php
session_start();


require_once "connexion.inc.php";

$stmt = $cnx->prepare("SELECT * FROM SAE_Client WHERE id_client = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();

$isAdmin = $_SESSION['is_admin'] ?? false;

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Primeurs-Passion</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <header>
        <div class="topbar">
            <div class="hamburger-menu">
                <input type="checkbox" id="menu-toggle" >
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

    <main>
 <?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$stmt_cat = $cnx->prepare("SELECT id_article, categorie FROM SAE_Article");
$stmt_cat->execute();
$categories = $stmt_cat->fetchAll(PDO::FETCH_ASSOC);

foreach ($categories as $cat):
    $id_article = $cat['id_article'];  
    $categorie = $cat['categorie'];

    $stmt_var = $cnx->prepare("SELECT * FROM SAE_Variete WHERE id_article = :id_article");
    $stmt_var->execute(['id_article' => $id_article]);
    $products = $stmt_var->fetchAll(PDO::FETCH_ASSOC);
?>
    <section>
        <h2><?= htmlspecialchars($categorie) ?></h2>
        <div class="product-grid">
            <?php if (count($products) === 0): ?>
                <p>Aucun produit disponible.</p>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <img src="img_pp/tomates.jpg" alt="<?= htmlspecialchars($product['nom']) ?>" />
                        <p class="name"><?= htmlspecialchars($product['nom']) ?></p>
                        <p 
                            class="panier btn-add-cart" 
                            data-variete-id="<?= htmlspecialchars($product['id_variete']) ?>"
                            style="cursor:pointer;"
                        >
                        <?= !empty($product['in_cart']) ? 'dans panier' : '+ au panier' ?>
                        </p>
                        <button>Acheter</button>
                        <p>Calibre: <?= htmlspecialchars($product['calibre']) ?></p>
                        <p>Prix: <?= $product['prix'] !== null ? $product['prix'] . ' €' : 'N/A' ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
<?php endforeach; ?>

    </main>

    <footer>
        <div class="footer-info">
            <div class="about">
                <h3>À propos</h3>
                <p>Primeurs-Passion une entreprise locale qui se consacre à la production de produits bio et locaux.<br>
                    Nous proposons des produits frais et de qualité</p>
            </div>
            <div class="contacts">
                <div>
                    <h4>Contact</h4>
                    <p>KEFA Yevhen<br>Adresse : 123, Rue, Ville, Pays<br>Email : contact@exemple.com<br>Téléphone : +123
                        456 7890</p>
                </div>
                <div>
                    <h4>Contact</h4>
                    <p>MUSY Loane<br>Adresse : 123, Rue, Ville, Pays<br>Email : contact@exemple.com<br>Téléphone : +123
                        456 7890</p>
                </div>
                <div>
                    <h4>Contact</h4>
                    <p>PERES Yanis<br>Adresse : 123, Rue, Ville, Pays<br>Email : contact@exemple.com<br>Téléphone : +123
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