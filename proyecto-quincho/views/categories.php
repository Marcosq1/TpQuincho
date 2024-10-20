<h1>Categorías</h1>
<a href="index.php?action=addCategory">Agregar Categoría</a>

<?php if (count($categories) > 0): ?>
    <ul>
        <?php foreach ($categories as $category): ?>
            <li>
                <img src="<?= $category['imagen_url'] ?>" alt="Imagen de <?= $category['nombre_categoria'] ?>" 
                     style="width: 50px; height: 50px; object-fit: cover;">
                <a href="index.php?action=viewItems&id=<?= $category['id_categoria'] ?>">
                    <?= $category['nombre_categoria'] ?>
                </a>
                <a href="index.php?action=editCategory&id=<?= $category['id_categoria'] ?>">Editar</a>
                <a href="index.php?action=deleteCategory&id=<?= $category['id_categoria'] ?>">Eliminar</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No hay categorías disponibles.</p>
<?php endif; ?>

<?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
    <a href="index.php?action=logout">Logout</a>
<?php else: ?>
    <a href="index.php?action=login">Login Admin</a>
<?php endif; ?>
