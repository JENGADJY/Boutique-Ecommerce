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
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
    <div class="container">
        <h2>Bienvenue, <?= htmlspecialchars($user['name']); ?> !</h2>
        <div class="profile-details">
            <p><strong>Email :</strong> <?= htmlspecialchars($user['email']); ?></p>
            <p><strong>Rôle :</strong> <?= htmlspecialchars($user['role']); ?></p>
        </div>

        <div class="actions">
            <a href="../index.php">Retour au site</a>
            <form action="logout.php" method="POST">
                <button type="submit">Se déconnecter</button>
            </form>
        </div>
    </div>
</body>
</html>
