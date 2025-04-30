<header>
    <div class="logo-container" onclick="window.location.href = 'index.php';">
        <img src="img/logo/logo-transparent-png.png" alt="logo" class="logo" />
    </div>
    <hr class="lane1" />
    <div class="header-container">
        <div id="menuToggle">
            <input type="checkbox" id="toggleMenu" />
            <span></span>
            <span></span>
            <span></span>
            <nav>
                <ul id="menu">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="categorie_produit.php">Catégories</a></li>
                    <li><a href="#">Contact</a></li>
                    <li class="profil-zoom">

                        <?php
                            if ($ok) {
                                echo '<a href="profil.php">Mon compte</a>';
                            }else {
                                echo '<a href="connection.php">Mon compte</a>';
                            }
                        ?>
                    </li>
                    <li class="panier-zoom">
                        <?php
                            if ($ok) {
                                echo '<a href="panier.php">Mon panier</a>';
                            }else {
                                echo '<a href="connection.php">Mon panier</a>';
                            }
                        ?>

                    </li>
                    <?php
                        if ($ok) {
                            echo '<li><a href="deconnexion.php">Deconnexion</a></li>';
                        }
                    ?>
                </ul>
            </nav>
        </div>
        <!-- barre de recherche avec icon loupe -->
        <div class="search-container">
            <input type="text" id="search-input" placeholder="Recherche..." />
            <button id="search-button">
                <img src="img/loupe.png" alt="Loupe" />
            </button>
        </div>
        <div class="profile-icon">
            <?php
            if ($ok) {
                echo '<button id="profile-button" onclick="window.location.href = \'profil.php\';">';
            } else {
                echo '<button id="profile-button" onclick="window.location.href = \'connection.php\';">';
            }
            ?>
            <i class="fa-solid fa-user style"></i>
            <br />
            <span>Profil</span>
            </button>
        </div>
        <div class="panier">
            <?php
            if ($ok) {
                echo '<button id="panier-button" onclick="window.location.href = \'panier.php\';">';
            } else {
                echo '<button id="panier-button" onclick="window.location.href = \'index.php\';">';
            }
            ?>
            <i class="fas fa-shopping-cart"></i>
            <br />
            <span>Panier</span>
            </button>
        </div>
    </div>
    <!-- icon de profil -->
    <hr class="lane2" />
</header>