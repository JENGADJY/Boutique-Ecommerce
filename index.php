<?php
require_once 'config/database.php';
require_once 'models/Product.php';
require 'controllers/ProductController.php'; 

$products = Product::getAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Boutique</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <h1>Bienvenue sur notre boutique</h1>
    
    <?php foreach ($products as $product): ?>
        <div style="margin-bottom: 20px;">
            <h2><?= htmlspecialchars($product['name']); ?></h2>
            <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" width="200">
            <p><?= htmlspecialchars($product['description']); ?></p>
            <p>Prix : <?= htmlspecialchars($product['price']); ?>€</p>
            
            <a href="page/product_detail.php?id=<?= $product['id']; ?>">Voir plus</a>

            <form action="cart.php" method="POST">
                <input type="hidden" name="id" value="<?= $product['id']; ?>">
                <button type="submit" name="add_to_cart">Ajouter au panier</button>
            </form>
        </div>
    <?php endforeach; ?>

</body>
</html>
