<?php
session_start();
require_once '../config/database.php';
require_once '../models/Product.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../page/login.php");
    exit();
}

$userId = $_SESSION['user']['id'];

// Récupérer les articles du panier depuis la base de données
$stmt = $conn->prepare("
    SELECT product_id, quantity 
    FROM cart 
    WHERE user_id = ?
");
$stmt->execute([$userId]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($cartItems)) {
    die("Votre panier est vide.");
}

$totalPrice = 0;
foreach ($cartItems as $item) {
    $product = Product::getById($item['product_id']);
    if ($product) {
        $totalPrice += $product['price'] * $item['quantity'];
    }
}

try {
    $conn->beginTransaction();

    // Création de la commande
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 'pending')");
    $stmt->execute([$userId, $totalPrice]);
    $orderId = $conn->lastInsertId();

    // Ajout des produits dans order_items
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, subtotal) VALUES (?, ?, ?, ?)");
    foreach ($cartItems as $item) {
        $product = Product::getById($item['product_id']);
        if ($product) {
            $stmt->execute([$orderId, $item['product_id'], $item['quantity'], $product['price'] * $item['quantity']]);
        }
    }

    // Vider le panier en base de données après la commande
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->execute([$userId]);

    $conn->commit();

    // Redirection après commande validée
    header("Location: ../page/order_success.php");
    exit();
} catch (Exception $e) {
    $conn->rollBack();
    die("Erreur lors de la commande : " . $e->getMessage());
}
?>
