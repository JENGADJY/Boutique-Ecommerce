<?php
session_start();
require_once '../models/Product.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Panier</title>
</head>
<body>
    <h2>Votre panier</h2>
    <?php foreach ($cart as $product_id): 
        $product = Product::getById($product_id);
    ?>
        <div>
            <h3><?= $product['name']; ?></h3>
            <p>Prix : <?= $product['price']; ?>€</p>
        </div>
    <?php endforeach; ?>
</body>
</html>
