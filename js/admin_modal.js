document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', () => {
            const userId = button.getAttribute('data-user-id');

            // Відкриття модалки
            const modal = document.getElementById('editModal');
            modal.style.display = 'block';

            // Записати ID
            document.getElementById('edit_user_id').value = userId;

            // Отримати дані клієнта (AJAX)
            fetch(`get_client.php?id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_nom').value = data.nom;
                    document.getElementById('edit_prenom').value = data.prenom;
                    document.getElementById('edit_adresse').value = data.adresse;
                    document.getElementById('edit_tel').value = data.tel;
                    document.getElementById('edit_email').value = data.email;
                    document.getElementById('edit_categorie').value = data.categorie_client;
                });
        });
    });

    document.querySelector('.close').addEventListener('click', () => {
        document.getElementById('editModal').style.display = 'none';
    });

    window.addEventListener('click', event => {
        const modal = document.getElementById('editModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});
