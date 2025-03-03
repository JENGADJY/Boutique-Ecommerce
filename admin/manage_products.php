<?php
session_start();
require_once '../config/database.php';
require_once '../controllers/ProductController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../page/error_admin.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Produits</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Liste des produits</h2>
    
    <div class="product-list">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" class="product-image">
                <h2><?= htmlspecialchars($product['name']); ?></h2>
                <p>Prix : <strong><?= htmlspecialchars($product['price']); ?>€</strong></p>

                 <!-- Pour modifier le prix  -->
                <form action="../controllers/ProductController.php" method="POST">
                    <input type="hidden" name="id" value="<?= $product['id']; ?>">
                    <input type="number" name="price" value="<?= htmlspecialchars($product['price']); ?>" step="0.01" required>
                    <button type="submit" name="update">Modifier le prix</button>
                </form>

                <!-- Pour supprimer un article  -->
                <form action="../controllers/ProductController.php" method="POST">
                    <input type="hidden" name="id" value="<?= $product['id']; ?>">
                    <button type="submit" name="delete" class="delete-btn"> Supprimer</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
