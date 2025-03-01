<?php
session_start();
require_once '../config/database.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$stmt = $conn->prepare("SELECT id, email FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    session_destroy();
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Bienvenue sur votre profil</h2>
    <p><strong>Email :</strong> <?= htmlspecialchars($user['email']); ?></p>
    <a href="logout.php">Se déconnecter</a>
</body>
</html>
