<?php
session_start();
require_once 'config/database.php';
require_once 'models/Product.php';
require 'controllers/ProductController.php'; 

$products = Product::getAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Boutique</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

    <div class="container">
        <div class="header-buttons">
            <a href="page/profile.php"><button>Profile</button></a>
            <a href="page/cart.php"><button>Panier</button></a>

            <!-- Ajout du bouton Panel Admin si l'utilisateur est admin -->
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                <a href="admin/dashboard.php"><button>Panel Admin</button></a>
            <?php endif; ?>
        </div>  
        <h1>Bienvenue sur notre boutique</h1>

        <div class="products-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <a href="page/product_detail.php?id=<?= $product['id']; ?>">
                    <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                    <h2><?= htmlspecialchars($product['name']); ?></h2>
                    <p><?= htmlspecialchars($product['description']); ?></p>
                    <p class="price">Prix : <?= htmlspecialchars($product['price']); ?>€</p>
                    <form action="page/cart.php" method="POST">
                        <input type="hidden" name="id" value="<?= $product['id']; ?>">
                        <button type="submit" name="add_to_cart">Ajouter au panier</button>
                    </form>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>
