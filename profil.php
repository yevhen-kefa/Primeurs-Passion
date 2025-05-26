<?php
session_start();

require_once "connexion.inc.php";

// Завантаження даних користувача з таблиці SAE_Client
$stmt = $cnx->prepare("SELECT * FROM SAE_Client WHERE id_client = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();

$isAdmin = $_SESSION['is_admin'] ?? false;

// Обробка оновлення профілю
if ($_POST && isset($_POST['update_profile'])) {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $date_naissance = $_POST['date_naissance'] ?? '';
    $genre = $_POST['genre'] ?? '';
    $adresse = $_POST['adresse'] ?? '';
    $email = $_POST['email'] ?? '';
    
    $update_stmt = $cnx->prepare("UPDATE SAE_Client SET nom = :nom, prenom = :prenom, date_naissance = :date_naissance, genre = :genre, adresse = :adresse, email = :email WHERE id_client = :id");
    $update_stmt->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'date_naissance' => $date_naissance,
        'genre' => $genre,
        'adresse' => $adresse,
        'email' => $email,
        'id' => $_SESSION['user_id']
    ]);
    
    // Оновлення даних користувача
    $stmt->execute(['id' => $_SESSION['user_id']]);
    $user = $stmt->fetch();
    
    $success_message = "Profil mis à jour avec succès!";
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil - Primeurs-Passion</title>
    <link rel="stylesheet" href="style.css" />
    <style>
        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: #dff8f0;
            min-height: calc(100vh - 200px);
        }

        .profile-title {
            font-size: 48px;
            font-weight: bold;
            color: #333;
            margin: 20px 0;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .profile-header {
            background: linear-gradient(135deg, #c8e6c9 0%, #a5d6a7 100%);
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            background: #bbb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: #666;
        }

        .profile-name {
            font-size: 36px;
            font-weight: bold;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .edit-icon {
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }

        .profile-content {
            display: flex;
            gap: 20px;
        }

        .sidebar-menu {
            flex: 0 0 200px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .menu-item {
            background: #a8c896;
            padding: 15px 20px;
            border-radius: 25px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            text-align: left;
            font-size: 14px;
        }

        .menu-item:hover,
        .menu-item.active {
            background: #8fb87a;
            transform: translateX(5px);
        }

        .profile-form {
            flex: 1;
            background: linear-gradient(135deg, #c8e6c9 0%, #a5d6a7 100%);
            padding: 30px;
            border-radius: 15px;
        }

        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-field {
            width: 100%;
            padding: 15px;
            background: #a8c896;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            color: #333;
            margin-bottom: 15px;
        }

        .form-field::placeholder {
            color: #666;
        }

        .form-field:focus {
            outline: none;
            background: #98b886;
        }

        .success-message {
            background: #4caf50;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .save-btn {
            background: #4caf50;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .save-btn:hover {
            background: #45a049;
        }

        .orders-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .order-item {
            background: #a8c896;
            padding: 20px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-date {
            font-weight: bold;
            color: #333;
        }

        .order-status {
            padding: 5px 15px;
            border-radius: 15px;
            background: #4caf50;
            color: white;
            font-size: 12px;
        }

        @media (max-width: 768px) {
            .profile-content {
                flex-direction: column;
            }
            
            .sidebar-menu {
                flex-direction: row;
                overflow-x: auto;
                flex: none;
            }
            
            .menu-item {
                white-space: nowrap;
                min-width: 150px;
            }
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
                        <li><a href="#">Catégories</a></li>
                        <li><a href="panier.html">Panier</a></li>
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
                <span>🛒 Panier</span>
            </div>
        </div>
    </header>

    <div class="profile-container">
        <h1 class="profile-title">Profil</h1>
        
        <div class="profile-header">
            <div class="profile-avatar">👤</div>
            <div class="profile-name">
            <?= htmlspecialchars($user['nom'] ?? '') . ' ' .  htmlspecialchars($user['prenom'] ?? '')?>
            </div>

        </div>

        <?php if (isset($success_message)): ?>
            <div class="success-message"><?= $success_message ?></div>
        <?php endif; ?>

        <div class="profile-content">
            <div class="sidebar-menu">
                <button class="menu-item active" onclick="showSection('info')">Informations personnelles</button>
                <button class="menu-item" onclick="showSection('confidentialite')">Confidentialité</button>
                <button class="menu-item" onclick="showSection('commandes')">Commandes</button>
                <button class="menu-item" onclick="showSection('parametres')">Paramètres</button>
            </div>

            <div class="profile-form">
                <form method="POST" action="">
                    <div id="info" class="form-section active">
                        <h3>Informations personnelles</h3>
                        <div class="form-group">
                            <input type="text" name="nom" class="form-field" placeholder="Nom" 
                                   value="<?= htmlspecialchars($user['nom'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" name="prenom" class="form-field" placeholder="Prénom" 
                                   value="<?= htmlspecialchars($user['prenom'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <input type="date" name="date_naissance" class="form-field" placeholder="Date de Naissance" 
                                   value="<?= htmlspecialchars($user['date_naissance'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <select name="genre" class="form-field">
                                <option value="">Genre</option>
                                <option value="M" <?= ($user['genre'] ?? '') === 'M' ? 'selected' : '' ?>>Masculin</option>
                                <option value="F" <?= ($user['genre'] ?? '') === 'F' ? 'selected' : '' ?>>Féminin</option>
                                <option value="A" <?= ($user['genre'] ?? '') === 'A' ? 'selected' : '' ?>>Autre</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-field" placeholder="Email" 
                                   value="<?= htmlspecialchars($user['email'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <textarea name="adresse" class="form-field" placeholder="Coordonnées (Adresse complète)" rows="3"><?= htmlspecialchars($user['adresse'] ?? '') ?></textarea>
                        </div>
                        <button type="submit" name="update_profile" class="save-btn">Sauvegarder</button>
                    </div>
                </form>

                <div id="confidentialite" class="form-section">
                    <h3>Paramètres de confidentialité</h3>
                    <p>Gérez vos paramètres de confidentialité et de sécurité.</p>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" checked> Autoriser l'utilisation de mes données pour améliorer le service
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox"> Recevoir des notifications par email
                        </label>
                    </div>
                    <button class="save-btn">Sauvegarder les préférences</button>
                </div>

                <div id="commandes" class="form-section">
                    <h3>Historique des commandes</h3>
                    <div class="orders-list">
                        <div class="order-item">
                            <div>
                                <div class="order-date">Commande #001 - 15/01/2025</div>
                                <div>Fraises, Tomates, Pommes - 45.50€</div>
                            </div>
                            <div class="order-status">Livrée</div>
                        </div>
                        <div class="order-item">
                            <div>
                                <div class="order-date">Commande #002 - 20/01/2025</div>
                                <div>Légumes variés - 32.00€</div>
                            </div>
                            <div class="order-status">En cours</div>
                        </div>
                    </div>
                </div>

                <div id="parametres" class="form-section">
                    <h3>Paramètres du compte</h3>
                    <div class="form-group">
                        <input type="password" class="form-field" placeholder="Nouveau mot de passe">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-field" placeholder="Confirmer le mot de passe">
                    </div>
                    <button class="save-btn">Changer le mot de passe</button>
                    
                    <hr style="margin: 30px 0; border: 1px solid #ccc;">
                    
                    <div class="form-group">
                        <button style="background: #f44336;" class="save-btn">Supprimer le compte</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <script>
        function showSection(sectionId) {
            // Hide all sections
            const sections = document.querySelectorAll('.form-section');
            sections.forEach(section => section.classList.remove('active'));
            
            // Remove active class from all menu items
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => item.classList.remove('active'));
            
            // Show selected section
            document.getElementById(sectionId).classList.add('active');
            
            // Add active class to clicked menu item
            event.target.classList.add('active');
        }
    </script>
</body>

</html>