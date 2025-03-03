<?php
session_start();
require_once '../config/database.php';
require_once '../models/Product.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../page/login.php");
    exit();
}



$userId = $_SESSION['user']['id'];
$cartItems = array_count_values($_SESSION['cart']);
$totalPrice = 0;

foreach ($cartItems as $productId => $quantity) {
    $product = Product::getById($productId);
    if ($product) {
        $totalPrice += $product['price'] * $quantity;
    }
}

try {
    $conn->beginTransaction();
    # Creation de la commande dans la db 

    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 'pending')");
    $stmt->execute([$userId, $totalPrice]);
    $orderId = $conn->lastInsertId();
    # Creation de les produits de la commande dans la db 
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, subtotal) VALUES (?, ?, ?, ?)");
    foreach ($cartItems as $productId => $quantity) {
        $product = Product::getById($productId);
        if ($product) {
            $stmt->execute([$orderId, $productId, $quantity, $product['price'] * $quantity]);
        }
    }

    $conn->commit();

    unset($_SESSION['cart']);
    #Simulation de paiement accepté
    header("Location: ../page/order_success.php");
    exit();
} catch (Exception $e) {
    $conn->rollBack();
    die("Erreur lors de la commande : " . $e->getMessage());
}
?>
