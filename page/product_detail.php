<?php
require_once '../config/database.php';
require_once '../models/Product.php';
require '../controllers/ProductController.php'; 
#si le produit existe bien 
if (!isset($_GET['id'])) {
    die("Produit introuvable.");
}

$product = Product::getById($_GET['id']);

if (!$product) {
    die("Produit non trouvé.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="../css/product.css">
</head>
<body>
    <a href="../index.php">Retour à la boutique</a>
    <h1><?= htmlspecialchars($product['name']); ?></h1>
    <p><?= htmlspecialchars($product['description']); ?></p>
    <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
    <p>Prix : <?= htmlspecialchars($product['price']); ?>€</p>

    <form action="../controllers/CartController.php" method="POST">
        <input type="hidden" name="id" value="<?= $product['id']; ?>">
        <button type="submit">Ajouter au panier</button>
    </form>
    <br>
</body>
</html>
