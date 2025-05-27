document.addEventListener('DOMContentLoaded', function () {
    const addBtn = document.getElementById('addProductBtn');
    const addModal = document.getElementById('addProductModal');
    const addClose = addModal.querySelector('.close');

    addBtn.onclick = () => { addModal.style.display = 'block'; }
    addClose.onclick = () => { addModal.style.display = 'none'; }
    window.onclick = (e) => {
        if (e.target === addModal) addModal.style.display = 'none';
    };

    const editModal = document.getElementById('editProductModal');
    const editClose = editModal.querySelector('.close');

    document.querySelectorAll('button.btn-edit-p').forEach(button => {
    button.addEventListener('click', () => {
        const tr = button.closest('tr');
        const productId = tr.querySelector('td:first-child').textContent.trim();

        const editModal = document.getElementById('editProductModal');
        editModal.style.display = 'block';
        document.getElementById('edit_product_id').value = productId;

        fetch(`products_admin.php?id=${productId}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('edit_nom').value = data.nom;
                document.getElementById('edit_calibre').value = data.calibre;
                document.getElementById('edit_prix').value = data.prix ?? '';
                document.getElementById('edit_id_article').value = data.id_article;
            })
            .catch(error => {
                console.error('Помилка при завантаженні продукту:', error);
                alert('Не вдалося завантажити дані продукту');
            });
    });
});

    editClose.onclick = () => { editModal.style.display = 'none'; }
    window.addEventListener('click', (e) => {
        if (e.target === editModal) editModal.style.display = 'none';
    });
});
