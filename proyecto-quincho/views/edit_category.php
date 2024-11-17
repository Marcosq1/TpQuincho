<h1>Editar Categoría</h1>
<form method="POST" enctype="multipart/form-data">
    <label for="name">Nombre de la Categoría:</label>
    <input type="text" name="name" value="<?= $category['nombre_categoria'] ?>" required>
    <label for="image">Imagen (URL):</label>
    <input type="text" name="image_url" value="<?= $category['imagen_url'] ?>">
    <button type="submit">Guardar Cambios</button>
</form>
<a href="index.php?action=listCategories">Cancelar</a>