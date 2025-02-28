<?php require '../controllers/ProductController.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Boutique</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <h1>Bienvenue sur notre boutique</h1>
    
    <?php foreach ($products as $product): ?>
        <div style="margin-bottom: 20px;">
            <h2><?= htmlspecialchars($product['name']); ?></h2>
            <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" width="200">
            <p><?= htmlspecialchars($product['description']); ?></p>
            <p>Prix : <?= htmlspecialchars($product['price']); ?>€</p>
            <a href="product_detail.php?id=<?= $product['id']; ?>">Voir plus</a>
        </div>
    <?php endforeach; ?>

</body>
</html>
