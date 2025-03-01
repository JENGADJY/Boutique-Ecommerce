<?php
require_once __DIR__ . '/../models/Product.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        Product::add($_POST['name'], $_POST['description'], $_POST['price'], $_POST['stock']);
        header("Location: ../admin/manage_products.php");
        exit();
    }
    if (isset($_POST['delete'])) {
        Product::delete($_POST['id']);
        header("Location: ../admin/manage_products.php");
        exit();
    }
    if (isset($_POST['update']) && isset($_POST['id']) && isset($_POST['price'])) {
        Product::updatePrice($_POST['id'], $_POST['price']);
        header("Location: ../admin/manage_products.php");
        exit();
    }
}

$products = Product::getAll();
?>
