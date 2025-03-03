<?php
session_start();
require_once '../config/database.php';
require_once '../controllers/ProductController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../page/error_admin.php");
    exit();
}

$products = Product::getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    // Ajouter un produit
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    
    Product::add($name, $description, $price, $stock);
    header("Location: manage_products.php"); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    // Mettre à jour un produit
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    
    Product::update($id, $name, $description, $price, $stock);
    header("Location: manage_products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Produits</title>
    <link rel="stylesheet" href="../css/manage_products.css">
</head>
<body>
    <div class="admin-dashboard">
        <!-- Bouton Retour au Tableau de Bord -->
        <div class="back-btn-container">
            <a href="dashboard.php" class="back-btn">Retour au tableau de bord</a>
        </div>

        <h2>Liste des produits</h2>

        <!-- Formulaire pour ajouter un produit -->
        <h3>Ajouter un produit</h3>
        <form method="POST" action="manage_products.php">
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" required>
            <label for="description">Description :</label>
            <textarea id="description" name="description" required></textarea>
            <label for="price">Prix :</label>
            <input type="number" id="price" name="price" step="0.01" required>
            <label for="stock">Stock :</label>
            <input type="number" id="stock" name="stock" required>
            <button type="submit" name="add_product" class="add-btn">Ajouter le produit</button>
        </form>
        
        <div class="product-list">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" class="product-image">
                    <h3><?= htmlspecialchars($product['name']); ?></h3>
                    <p>Prix : <strong><?= htmlspecialchars($product['price']); ?>€</strong></p>
                    
                    <!-- Formulaire de modification du nom, description, prix et stock -->
                    <form method="POST" action="manage_products.php">
                        <input type="hidden" name="id" value="<?= $product['id']; ?>">
                        <label for="name">Nom :</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($product['name']); ?>" required>
                        
                        <label for="description">Description :</label>
                        <textarea name="description" required><?= htmlspecialchars($product['description']); ?></textarea>
                        
                        <label for="price">Prix :</label>
                        <input type="number" name="price" value="<?= htmlspecialchars($product['price']); ?>" step="0.01" required>
                        
                        <label for="stock">Stock :</label>
                        <input type="number" name="stock" value="<?= htmlspecialchars($product['stock']); ?>" required>
                        
                        <button type="submit" name="update_product" class="update-btn">Modifier</button>
                    </form>

                    <!-- Formulaire de suppression d'un produit -->
                    <form action="../controllers/ProductController.php" method="POST">
                        <input type="hidden" name="id" value="<?= $product['id']; ?>">
                        <button type="submit" name="delete" class="delete-btn">Supprimer</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</body>
</html>
