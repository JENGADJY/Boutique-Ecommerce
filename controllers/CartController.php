<?php
session_start();
require_once '../models/Product.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $_SESSION['cart'][] = $_POST['id'];
    header("Location: ../views/cart.php");
    exit();
}
?>
