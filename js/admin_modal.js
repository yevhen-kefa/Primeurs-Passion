document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', () => {
            const userId = button.getAttribute('data-user-id');

            const modal = document.getElementById('editModal');
            modal.style.display = 'block';

            document.getElementById('edit_user_id').value = userId;

            fetch(`get_client.php?id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_user_nom').value = data.nom;
                    document.getElementById('edit_user_prenom').value = data.prenom;
                    document.getElementById('edit_user_adresse').value = data.adresse;
                    document.getElementById('edit_user_tel').value = data.tel;
                    document.getElementById('edit_user_email').value = data.email;
                    document.getElementById('edit_user_categorie').value = data.categorie_client;
                });
        });
    });

    document.querySelector('#editModal .close').addEventListener('click', () => {
        document.getElementById('editModal').style.display = 'none';
    });

    window.addEventListener('click', event => {
        const modal = document.getElementById('editModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});
