<?php
require_once 'config/database.php';
require_once 'models/Product.php';

$products = Product::getAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Accueil - Boutique</title>
</head>
<body>
    <h1>Bienvenue sur notre boutique</h1>
    
    <?php foreach ($products as $product): ?>
        <div>
            <h2><?= htmlspecialchars($product['name']); ?></h2>
            <p><?= htmlspecialchars($product['description']); ?></p>
            <p>Prix : <?= htmlspecialchars($product['price']); ?>€</p>
            <form action="cart.php" method="POST">
                <input type="hidden" name="id" value="<?= $product['id']; ?>">
                <button type="submit">Ajouter au panier</button>
            </form>
        </div>
    <?php endforeach; ?>
</body>
</html>
