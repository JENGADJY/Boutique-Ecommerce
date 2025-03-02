<?php
session_start();
require_once '../config/database.php';  // Ajoute la connexion à la BDD
require_once '../models/Product.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../page/login.php");
    exit();
}

$userId = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $productId = $_POST['id'];

    // Vérifier si le produit est déjà dans le panier
    $stmt = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$userId, $productId]);
    $cartItem = $stmt->fetch();

    if ($cartItem) {
        // Si le produit est déjà présent, on augmente la quantité
        $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
    } else {
        // Sinon, on insère un nouveau produit dans le panier
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
        $stmt->execute([$userId, $productId]);
    }

    header("Location: cart.php");
    exit();
}

// Récupérer les articles du panier depuis la base de données
$stmt = $conn->prepare("
    SELECT p.id, p.name, p.price, p.image, c.quantity 
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
");
$stmt->execute([$userId]);
$cartItems = $stmt->fetchAll();
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
        
        <?php if (empty($cartItems)): ?>
            <p>Votre panier est vide.</p>
        <?php else: ?>
            <?php foreach ($cartItems as $item): ?>
                <div class="cart-item">
                    <img src="<?= htmlspecialchars($item['image']); ?>" alt="<?= htmlspecialchars($item['name']); ?>">
                    <div class="details">
                        <h3><?= htmlspecialchars($item['name']); ?></h3>
                        <p>Prix : <?= htmlspecialchars($item['price']); ?>€</p>
                        <p>Quantité : <?= $item['quantity']; ?></p>
                    </div>
                    <form action="../controllers/CartController.php" method="POST">
                        <input type="hidden" name="id" value="<?= $item['id']; ?>">
                        <button type="submit" name="remove">Supprimer</button>
                    </form>
                </div>
            <?php endforeach; ?>

            <form action="../controllers/CartController.php" method="POST">
                <button type="submit" name="clear_cart">Vider le panier</button>
            </form>

            <form action="../controllers/OrderController.php" method="POST">
                <button type="submit" name="place_order" class="order-btn">Passer la commande</button>
            </form>
        <?php endif; ?>

        <br>
        <a href="../index.php">⬅ Retour à la boutique</a>
    </div>
</body>
</html>
