document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById("addModal");
    const openBtn = document.getElementById("openAddModal");
    const closeBtn = document.querySelector(".modal .close");

    openBtn.onclick = function () {
        modal.style.display = "block";
    }

    closeBtn.onclick = function () {
        modal.style.display = "none";
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});