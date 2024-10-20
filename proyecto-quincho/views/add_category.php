<h1>Agregar Categoría</h1>
<form method="POST" enctype="multipart/form-data">
    <label for="name">Nombre de la Categoría:</label>
    <input type="text" name="name" required>
    <label for="image">Imagen (URL):</label>
    <input type="text" name="image_url">
    <button type="submit">Agregar</button>
</form>
<a href="index.php?action=listCategories">Cancelar</a>