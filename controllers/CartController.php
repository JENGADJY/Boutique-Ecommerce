<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../page/login.php");
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
    $product_id = $_POST['id'];
    $index = array_search($product_id, $_SESSION['cart']);
    if ($index !== false) {
        unset($_SESSION['cart'][$index]);
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']); 
}

header("Location: ../views/cart.php");
exit();
?>
