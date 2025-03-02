<?php
session_start();
require_once '../models/Product.php';

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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Votre Panier</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Votre Panier</h1>
        <?php
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $cartItems = array_count_values($cart);

        foreach ($cartItems as $productId => $quantity):
            $product = Product::getById($productId);
        ?>
            <div class="cart-item">
                <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                <div class="details">
                    <h3><?= htmlspecialchars($product['name']); ?></h3>
                    <p>Prix : <?= htmlspecialchars($product['price']); ?>€</p>
                    <p>Quantité : <?= $quantity; ?></p>
                </div>
                <form action="../controllers/CartController.php" method="POST">
                    <input type="hidden" name="id" value="<?= $productId; ?>">
                    <button type="submit" name="remove">Supprimer</button>
                </form>
            </div>
        <?php endforeach; ?>

        <br>
        <a href="../index.php">⬅ Retour à la boutique</a>
        <?php if (!empty($cart)): ?>
            <form action="../controllers/OrderController.php" method="POST">
                <button type="submit" name="place_order" class="order-btn">Passer la commande</button>
            </form>
        <?php endif; ?>

    </div>
</body>
</html>
