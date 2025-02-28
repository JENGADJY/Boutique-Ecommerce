<?php
require_once '../models/Product.php';

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
</head>
<body>
    <h1><?= htmlspecialchars($product['name']); ?></h1>
    <p><?= htmlspecialchars($product['description']); ?></p>
    <p>Prix : <?= htmlspecialchars($product['price']); ?>€</p>
    <form action="../controllers/CartController.php" method="POST">
        <input type="hidden" name="id" value="<?= $product['id']; ?>">
        <button type="submit">Ajouter au panier</button>
    </form>
    <br>
    <a href="../index.php">Retour à la boutique</a>
</body>
</html>
