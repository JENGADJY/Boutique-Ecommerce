<?php
session_start();
require_once '../config/database.php'; 

if (!isset($_SESSION['user'])) {
    header("Location: ../page/login.php");
    exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Bienvenue, <?= htmlspecialchars($user['name']); ?> !</h2>
    <p><strong>Email :</strong> <?= htmlspecialchars($user['email']); ?></p>
    <p><strong>Rôle :</strong> <?= htmlspecialchars($user['role']); ?></p>
    <li><a href="../index.php"> Retour au site</a></li>

    <a href="logout.php">Se déconnecter</a>
</body>
</html>
