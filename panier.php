<?php
session_start();


require_once "connexion.inc.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
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
                        <li><a href="index.html">Accueil</a></li>
                        <li><a href="#">Catégories</a></li>
                        <li><a href="panier.html">Panier</a></li>
                    </ul>
                </div>
            </div>
            <div class="logo">🍓 PRIMEURS-PASSION<br><small>Vos produits à votre porte</small></div>
            <input type="text" placeholder="Recherche..." class="search-bar" />
            <div class="icons">
                <span>👤 Login</span>
                <span>🛒 Panier</span>
            </div>
        </div>
    </header>

    <main>
        <h2>Votre panier</h2>
        <hr>
        <p class="total">Prix total: xxx$</p>
        <div class="cart">
            <!-- Produit -->
            <div class="item">
                <img src="img_pp/fraises.jpg" alt="Fraises" />
                <div class="details">
                    <h3>Fraises</h3>
                    <p>Prix: xxx$</p>
                </div>
                <div class="quantity">
                    <button>-</button>
                    <span>1</span>
                    <button>+</button>
                </div>
                <button class="delete">Supprimer</button>
            </div>

            <div class="item">
                <img src="img_pp/fraises.jpg" alt="Fraises" />
                <div class="details">
                    <h3>Fraises</h3>
                    <p>Prix: xxx$</p>
                </div>
                <div class="quantity">
                    <button>-</button>
                    <span>1</span>
                    <button>+</button>
                </div>
                <button class="delete">Supprimer</button>
            </div>

            <div class="item">
                <img src="img_pp/fraises.jpg" alt="Fraises" />
                <div class="details">
                    <h3>Fraises</h3>
                    <p>Prix: xxx$</p>
                </div>
                <div class="quantity">
                    <button>-</button>
                    <span>1</span>
                    <button>+</button>
                </div>
                <button class="delete">Supprimer</button>
            </div>

            <div class="item">
                <img src="img_pp/fraises.jpg" alt="Fraises" />
                <div class="details">
                    <h3>Fraises</h3>
                    <p>Prix: xxx$</p>
                </div>
                <div class="quantity">
                    <button>-</button>
                    <span>1</span>
                    <button>+</button>
                </div>
                <button class="delete">Supprimer</button>
            </div>

            <div class="item">
                <img src="img_pp/fraises.jpg" alt="Fraises" />
                <div class="details">
                    <h3>Fraises</h3>
                    <p>Prix: xxx$</p>
                </div>
                <div class="quantity">
                    <button>-</button>
                    <span>1</span>
                    <button>+</button>
                </div>
                <button class="delete">Supprimer</button>
            </div>

            <div class="item">
                <img src="img_pp/fraises.jpg" alt="Fraises" />
                <div class="details">
                    <h3>Fraises</h3>
                    <p>Prix: xxx$</p>
                </div>
                <div class="quantity">
                    <button>-</button>
                    <span>1</span>
                    <button>+</button>
                </div>
                <button class="delete">Supprimer</button>
            </div>

        </div>
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

</html>