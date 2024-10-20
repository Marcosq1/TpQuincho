<h1>Ítems de la Categoría</h1>
<ul>
    <?php foreach ($items as $item): ?>
        <li><?= $item['nombre_item'] ?></li>
    <?php endforeach; ?>
</ul>
<a href="index.php?action=listCategories">Volver a Categorías</a>
