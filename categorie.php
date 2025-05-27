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
$stmt = $cnx->prepare("SELECT * FROM SAE_Client WHERE id_client = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();
$stmt = $cnx->query("SELECT id_article, categorie FROM sae_article ORDER BY categorie");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Catégories - Primeurs-Passion</title>
    <link rel="stylesheet" href="style.css" />
    <style>
        /* Styles spécifiques pour la page catégories */
        .categories-container {
            margin: 40px 5% 40px 5%;
            padding: 20px;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .category-card {
            background: #B3DEC1;
            border: 2px solid #9BC7A8;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            min-height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            background: #A8D4B5;
        }

        .category-card a {
            text-decoration: none;
            color: #2d3e2a;
            display: block;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .category-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .category-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #2d3e2a;
        }

        .category-description {
            font-size: 14px;
            color: #4a5a47;
            line-height: 1.4;
        }

        .page-title {
            text-align: center;
            font-size: 36px;
            font-weight: bold;
            color: #2d3e2a;
            margin: 40px 0 20px 0;
            font-family: "Arial Black", sans-serif;
        }

        .page-subtitle {
            text-align: center;
            font-size: 18px;
            color: #4a5a47;
            margin-bottom: 40px;
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
                        <li><a href="categories.php">Catégories</a></li>
                        <li><a href="panier.html">Panier</a></li>
                        <li><a href="admin.php">Page admin utilisateur</a></li>
                        <li><a href="admin_loisir.php">Page admin loisir</a></li>
                        <li><a href="Agenda_globale.php">Calendrier globale</a></li>
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
        <div class="categories-container">
    <h1 class="page-title">Nos Catégories</h1>
    <p class="page-subtitle">Découvrez notre large gamme de produits frais et bio</p>

    <div class="categories-grid">
        <?php foreach ($categories as $cat): ?>
            <div class="category-card">
                <a href="categorie_concret.php?cat=<?= urlencode($cat['categorie']) ?>">

                    <div class="category-icon">🍎</div> 
                    <div class="category-name"><?= htmlspecialchars($cat['categorie']) ?></div>
                    <div class="category-description">
                        Produits dans la catégorie <?= htmlspecialchars($cat['categorie']) ?>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
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

</html>