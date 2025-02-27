<?php require '../controllers/ProductController.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Accueil</title>
</head>
<body>
    <h1>Bienvenue sur notre boutique</h1>
    <?php foreach ($products as $product): ?>
        <div>
            <h2><?= $product['name']; ?></h2>
            <p><?= $product['description']; ?></p>
            <p>Prix : <?= $product['price']; ?>€</p>
            <a href="product_detail.php?id=<?= $product['id']; ?>">Voir plus</a>
        </div>
    <?php endforeach; ?>
</body>
</html>
