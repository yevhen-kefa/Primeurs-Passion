<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "connexion.inc.php";
require "produit.php";

if (!isset($cnx)) {
    die("Connexion à la base de données non établie.");
}

//Delete users
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
    $deleteId = intval($_POST['delete_user_id']);

    try {
        $stmt = $cnx->prepare("DELETE FROM SAE_Client WHERE id_client = ?");
        $stmt->execute([$deleteId]);
    } catch (PDOException $e) {
    }
}

//Delete produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product_id'])) {
    $deleteId = intval($_POST['delete_product_id']);

    try {
        $stmt = $cnx->prepare("DELETE FROM SAE_Variete WHERE id_variete = ?");
        $stmt->execute([$deleteId]);

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erreur lors de la suppression : " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}

$stmt = $cnx->prepare("SELECT * FROM SAE_Client WHERE id_client = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();

$isAdmin = $_SESSION['is_admin'] ?? false;
if (!$isAdmin) {
    header("Location: index.php");
    exit;
}



//Get user

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $id = $_POST['user_id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $categorie = $_POST['categorie_client'];
    $password = $_POST['pass'];

    try {
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "UPDATE SAE_Client 
                    SET nom = :nom, prenom = :prenom, adresse = :adresse, tel = :tel, email = :email, categorie_client = :categorie, pass = :pass
                    WHERE id_client = :id";
            
            $stmt = $cnx->prepare($sql);
            $stmt->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':adresse' => $adresse,
                ':tel' => $tel,
                ':email' => $email,
                ':categorie' => $categorie,
                ':pass' => $hashedPassword,
                ':id' => $id
            ]);
        } else {
            $sql = "UPDATE SAE_Client 
                    SET nom = :nom, prenom = :prenom, adresse = :adresse, tel = :tel, email = :email, categorie_client = :categorie
                    WHERE id_client = :id";
            
            $stmt = $cnx->prepare($sql);
            $stmt->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':adresse' => $adresse,
                ':tel' => $tel,
                ':email' => $email,
                ':categorie' => $categorie,
                ':id' => $id
            ]);
        }

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour : " . $e->getMessage();
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_user'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $email = $_POST['email'];
    $tel = $_POST['telephone']; 
    $categorie_client = $_POST['categorie_client'];
    $codeClient = 'C' 
    . strtoupper(mb_substr($nom, 0, 3)) 
    . strtoupper(mb_substr($prenom, 0, 3));

    if (empty($_POST['pass'])) {
        $errorMessage = "Le mot de passe est obligatoire pour créer un utilisateur.";
    } else {
        $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

        $stmt = $cnx->prepare("SELECT id_client FROM public.sae_client WHERE email = :email");
        $stmt->execute(['email' => $email]);

        if ($stmt->rowCount() > 0) {
            $errorMessage = "Cet email est déjà utilisé.";
        } else {
            $stmt = $cnx->prepare("
                INSERT INTO sae_client (code_client,nom, prenom, adresse, email, pass, tel, categorie_client)
                VALUES (:code_client, :nom, :prenom, :adresse, :email, :pass, :tel, :categorie_client)
                RETURNING id_client
            ");

            $stmt->execute([
                'code_client' => $codeClient,
                'nom' => $nom,
                'prenom' => $prenom,
                'adresse' => $adresse,
                'email' => $email,
                'pass' => $pass,
                'tel' => $tel,
                'categorie_client' => $categorie_client
            ]);

            $userId = $stmt->fetchColumn();

            $successMessage = "L'utilisateur a été créé avec succès.";
        }
    }
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Page Admin - Primeurs-Passion</title>
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background: #dff8f0;
        }
        
        a {
            text-decoration: none;
        }
        
        header {
            background-color: #c4e3c5;
            padding: 10px;
        }

        .topbar {
            background: #bfe3c7;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            gap: 20px;
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
            margin-left: 12px;
        }

        /* Admin specific styles */
        .admin-header {
            margin: 40px 20px 20px 20px;
            font-family: "Arial Black", sans-serif;
            border-bottom: 2px solid black;
            width: fit-content;
            font-size: 32px;
            font-weight: bold;
            padding-bottom: 10px;
        }

        .admin-section {
            margin: 60px 20px 40px 20px;
        }

        .admin-section h2 {
            font-family: "Arial Black", sans-serif;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 30px;
            margin-left: 0;
            border: none;
        }

        .admin-content {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            min-height: 200px;
        }

        footer {
            background: #222;
            color: #fff;
            padding: 20px;
            margin-top: 100px;
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

        /* Table styles for admin lists */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .admin-table th,
        .admin-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .admin-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .admin-table tr:hover {
            background-color: #f9f9f9;
        }

        .btn {
            background: #d1e5bb;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            margin: 2px;
        }

        .btn:hover {
            background: #c4d8a7;
        }

        .btn-danger {
            background: #ffcccc;
        }

        .btn-danger:hover {
            background: #ffb3b3;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 700px;
            border-radius: 8px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: black;
        }

        form {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .submit-btn {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }

        .avatar-preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
        }

        .add-user-btn {
            background-color: #2196F3;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .password-toggle {
    position: relative;
}

.password-toggle input {
    padding-right: 40px;
}

.password-toggle button {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: #666;
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

    <main>
        <h1 class="admin-header">Page admin</h1>

        <?php
        $stmt = $cnx->prepare("SELECT id_client, nom, prenom, email FROM SAE_Client ORDER BY id_client");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

       <div class="admin-section">
            <h2>Liste des utilisateurs</h2>
            <button id="openAddModal" class="btn btn-primary" style="margin-bottom: 15px;">➕ Créer un utilisateur</button>

            <div class="admin-content">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom et Prénom</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id_client']) ?></td>
                            <td><?= htmlspecialchars($user['nom'] . ' ' . $user['prenom']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                                <button class="btn btn-edit" data-user-id="<?= htmlspecialchars($user['id_client']) ?>">Modifier</button>
                                 <form method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                    <input type="hidden" name="delete_user_id" value="<?= htmlspecialchars($user['id_client']) ?>">
                                    <button type="submit" class="btn btn-danger btn-delete">Supprimer</button>
                                </form>

                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>



        <div class="admin-section">
            <h2>Liste des produits</h2>
            <button id="addProductBtn" class="btn" style="margin-top: 20px;">Ajouter un produit</button>
            <div class="admin-content">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom du produit</th>
                            <th>Catégorie</th>
                            <th>Prix</th>
                            <th>Calibre</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        ini_set('display_errors', 1);
                        ini_set('display_startup_errors', 1);
                        error_reporting(E_ALL);

                        $stmt = $cnx->prepare("
                            SELECT v.id_variete, v.nom, a.categorie, v.prix, v.calibre
                            FROM SAE_Variete v
                            JOIN SAE_Article a ON v.id_article = a.id_article
                            ORDER BY v.id_variete
                        ");
                        $stmt->execute();
                        $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if (count($produits) === 0) {
                            echo '<tr><td colspan="6">Aucun produit disponible.</td></tr>';
                        } else {
                            foreach ($produits as $produit) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($produit['id_variete']) . '</td>';
                                echo '<td>' . htmlspecialchars($produit['nom']) . '</td>';
                                echo '<td>' . htmlspecialchars($produit['categorie']) . '</td>';
                                echo '<td>' . ($produit['prix'] !== null ? htmlspecialchars($produit['prix']) . ' €' : 'N/A') . '</td>';
                                echo '<td>' . htmlspecialchars($produit['calibre']) . '</td>';
                                echo '<td>
                                        <button class="btn btn-edit-p">Modifier</button>
                                         <form method="POST" style="display:inline;" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer ce produit ?\');">
                                            <input type="hidden" name="delete_product_id" value="' . htmlspecialchars($produit['id_variete']) . '">
                                            <button type="submit" class="btn btn-danger btn-delete">Supprimer</button>
                                        </form>
                                      </td>';
                                echo '</tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php
        $stmt_emp = $cnx->prepare("SELECT id_employe, prenom, nom, date_naissance, date_embauche, type_contrat, fonction FROM SAE_Employes ORDER BY id_employe");
        $stmt_emp->execute();
        $employees = $stmt_emp->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div class="admin-section">
            <h2>Liste des employés</h2>
            <div class="admin-content">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom et Prénom</th>
                            <th>Date de naissance</th>
                            <th>Date d'embauche</th>
                            <th>Type de contrat</th>
                            <th>Fonction</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employees as $emp): ?>
                        <tr>
                            <td><?= htmlspecialchars($emp['id_employe'] ?? '') ?></td>
                            <td><?= htmlspecialchars($emp['nom'] . ' ' . $emp['prenom']) ?></td>
                            <td><?= htmlspecialchars($emp['date_naissance']) ?></td>
                            <td><?= htmlspecialchars($emp['date_embauche']) ?></td>
                            <td><?= htmlspecialchars($emp['type_contrat']) ?></td>
                            <td><?= htmlspecialchars($emp['fonction']) ?></td>
                            <td>
                                <button class="btn">Modifier</button>
                                <button class="btn btn-danger">Supprimer</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

         <!-- Modal pour modifier un utilisateur -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Modifier le client</h2>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="user_id" id="edit_user_id">
            <input type="hidden" name="update_user" value="1">

            <div class="form-group">
                <label for="edit_nom">Nom:</label>
                <input type="text" id="edit_user_nom" name="nom" required>
            </div>

            <div class="form-group">
                <label for="edit_prenom">Prénom:</label>
                <input type="text" id="edit_prenom" name="prenom">
            </div>

            <div class="form-group">
                <label for="edit_adresse">Adresse:</label>
                <input type="text" id="edit_adresse" name="adresse">
            </div>

            <div class="form-group">
                <label for="edit_tel">Téléphone:</label>
                <input type="tel" id="edit_tel" name="tel">
            </div>

            <div class="form-group">
                <label for="edit_email">Email:</label>
                <input type="email" id="edit_email" name="email">
            </div>

            <div class="form-group">
                <label for="edit_categorie">Catégorie Client:</label>
                <select id="edit_categorie" name="categorie_client" required>
                    <option value="1">Particulier</option>
                    <option value="2">Professionnel</option>
                    <option value="3">VIP</option>
                    <option value="4">Autre</option>
                </select>
            </div>  

            <div class="form-group">
                <label for="edit_pass">Mot de passe (laisser vide pour ne pas modifier):</label>
                <input type="password" id="edit_pass" name="pass" placeholder="Ne pas modifier si vide">
            </div>

            <button type="submit" class="submit-btn">Mettre à jour</button>
        </form>
    </div>
</div>

<div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Ajouter un nouvel utilisateur</h2>
            <form id="addForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="create_user" value="1">
                
                <div class="form-group">
                    <label for="add_nom">Nom:</label>
                    <input type="text" id="add_nom" name="nom" required>
                </div>
                
                <div class="form-group">
                    <label for="add_prenom">Prénom:</label>
                    <input type="text" id="add_prenom" name="prenom" required>
                </div>
                
                <div class="form-group">
                    <label for="add_adresse">Adresse:</label>
                    <input type="text" id="add_adresse" name="adresse" required>
                </div>
                
                <div class="form-group">
                    <label for="add_email">Email:</label>
                    <input type="email" id="add_email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="add_pass">Mot de passe:</label>
                    <input type="password" id="add_pass" name="pass" required>
                </div>

                
                <div class="form-group">
                    <label for="add_telephone">Téléphone:</label>
                    <input type="tel" id="add_telephone" name="telephone">
                </div>
                
                
                <div class="form-group">
                <label for="edit_categorie">Catégorie Client:</label>
                <select id="edit_categorie" name="categorie_client" required>
                    <option value="1">Particulier</option>
                    <option value="2">Professionnel</option>
                    <option value="3">VIP</option>
                    <option value="4">Autre</option>
                </select>
            </div>  

                    <div class="form-group">
                    <label for="add_pass">Mot de passe:</label>
                    <input type="password" id="add_pass" name="pass" required placeholder="Mot de passe pour le nouvel utilisateur">
                    </div>
                
                <button type="submit" class="submit-btn">Créer l'utilisateur</button>
            </form>
        </div>
    </div>
<div id="addProductModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Ajouter un nouveau produit</h2>
        <form id="addProductForm" method="POST">
            <input type="hidden" name="create_product" value="1">

            <div class="form-group">
                <label for="add_nom">Nom du produit:</label>
                <input type="text" id="add_nom" name="nom" required>
            </div>

            <div class="form-group">
                <label for="add_calibre">Calibre:</label>
                <input type="text" id="add_calibre" name="calibre" required>
            </div>

            <div class="form-group">
                <label for="add_prix">Prix (€):</label>
                <input type="number" id="add_prix" name="prix" min="0" step="1">
            </div>

            <div class="form-group">
                <label for="add_id_article">Catégorie:</label>
                <select id="add_id_article" name="id_article" required>
                    <option value="1">Fruits</option>
                    <option value="2">Légumes</option>
                </select>
            </div>

            <button type="submit" class="btn">Ajouter</button>
        </form>
    </div>
</div>

<div id="editProductModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Modifier le produit</h2>
        <form id="editProductForm" method="POST">
            <input type="hidden" name="update_product" value="1">
            <input type="hidden" id="edit_product_id" name="product_id">

            <div class="form-group">
                <label for="edit_nom">Nom du produit:</label>
                <input type="text" id="edit_nom" name="nom" required>
            </div>

            <div class="form-group">
                <label for="edit_calibre">Calibre:</label>
                <input type="text" id="edit_calibre" name="calibre" required>
            </div>

            <div class="form-group">
                <label for="edit_prix">Prix (€):</label>
                <input type="number" id="edit_prix" name="prix" min="0" step="1">
            </div>

            <div class="form-group">
                <label for="edit_id_article">Catégorie:</label>
                <select id="edit_id_article" name="id_article" required>
                    <option value="1">Fruits</option>
                    <option value="2">Légumes</option>
                    <!-- Додай свої категорії -->
                </select>
            </div>

            <button type="submit" class="btn">Modifier</button>
        </form>
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
<script src="js/add_user.js"></script>
<script src="js/admin_modal.js"></script>
<script src="js/produit.js"></script>

</html>