<?php
session_start();
require_once '../models/Product.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$cartItems = array_count_values($cart);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
</head>
<body>
    <h2>Votre Panier</h2>
    
    <?php foreach ($cartItems as $product_id => $quantity): 
        $product = Product::getById($product_id);
    ?>
        <div>
            <h3><?= htmlspecialchars($product['name']); ?></h3>
            <p>Prix : <?= htmlspecialchars($product['price']); ?>€</p>
            <p>Quantité : <?= $quantity; ?></p>
            <form action="../controllers/CartController.php" method="POST">
                <input type="hidden" name="id" value="<?= $product_id; ?>">
                <button type="submit" name="remove">Supprimer</button>
            </form>
        </div>
    <?php endforeach; ?>

    <a href="../index.php">Retour à la boutique</a>
</body>
</html>
