<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../page/login.php");
    exit();
}

$stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || $user['role'] !== 'admin') {
    header("Location: ../page/error_admin.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Admin</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <h2>Tableau de bord - Administration</h2>

    <ul>
        <li><a href="manage_products.php">Gérer les produits</a></li>
        <li><a href="manage_users.php">Gérer les utilisateurs</a></li>
        <li><a href="../index.php">Retour au site</a></li>
        <li><a href="../logout.php">Déconnexion</a></li>
    </ul>
</body>
</html>
