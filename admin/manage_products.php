<?php
require_once '../controllers/ProductController.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestion des Produits</title>
</head>
<body>
    <h2>Liste des produits</h2>
    <?php foreach ($products as $product): ?>
        <div>
            <h2><?= htmlspecialchars($product['name']); ?></h2>
            <form action="../controllers/ProductController.php" method="POST">
                <input type="hidden" name="id" value="<?= $product['id']; ?>">
                <button type="submit" name="delete">Supprimer</button>
            </form>
        </div>
    <?php endforeach; ?>
</body>
</html>
