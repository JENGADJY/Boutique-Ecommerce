<?php
session_start();
require_once 'models/Product.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $_SESSION['cart'][] = $_POST['id'];
    header("Location: cart.php");
    exit();
}

$cartItems = array_count_values($_SESSION['cart']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Votre Panier</title>
</head>
<body>
    <h2>Votre Panier</h2>
    
    <?php foreach ($cartItems as $productId => $quantity): 
        $product = Product::getById($productId);
    ?>
        <div>
            <h3><?= htmlspecialchars($product['name']); ?></h3>
            <p>Prix : <?= htmlspecialchars($product['price']); ?>€</p>
            <p>Quantité : <?= $quantity; ?></p>
        </div>
    <?php endforeach; ?>

    <a href="index.php">Retour à la boutique</a>
</body>
</html>
