document.getElementById("toggleMenu").addEventListener("change", function () {
    var menu = document.getElementById("menu");
    if (this.checked) {
        menu.style.transform = "translate(0, 0)";
    } else {
        menu.style.transform = "translate(-100%, 0)";
    }
});

// Ajoute une classe lorsque la souris survole un élément du menu
document.addEventListener("DOMContentLoaded", function () {
    var menuItems = document.querySelectorAll(".categories-inline li");
    menuItems.forEach(function (item) {
        item.addEventListener("mouseover", function () {
            this.classList.add("hovered");
        });
        item.addEventListener("mouseout", function () {
            this.classList.remove("hovered");
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    var toggleButton = document.getElementById("toggleMenu");
    var menu = document.querySelector(".categories-inline ul");

    toggleButton.addEventListener("click", function () {
        menu.classList.toggle("open");
    });
});

// Fonction pour filtrer les résultats en fonction de la saisie de l'utilisateur
function filterResults() {
    // Récupérer la saisie de l'utilisateur
    var input = document.getElementById("search-input");
    var filter = input.value.toUpperCase();

    // Sélectionner tous les éléments à filtrer
    var items = document.getElementsByClassName("item");

    // Parcourir tous les éléments
    for (var i = 0; i < items.length; i++) {
        var item = items[i];
        var text = item.textContent || item.innerText;

        // Vérifier si le texte de l'élément correspond à la saisie de l'utilisateur
        if (text.toUpperCase().indexOf(filter) > -1) {
            item.style.display = ""; // Afficher l'élément si correspondance
        } else {
            item.style.display = "none"; // Masquer l'élément s'il n'y a pas de correspondance
        }
    }
}

// Attacher un gestionnaire d'événements au clic sur le bouton de recherche
var searchButton = document.getElementById("search-button");
searchButton.addEventListener("click", filterResults);
