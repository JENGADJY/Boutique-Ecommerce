<?php
session_start();
require_once '../config/database.php';
require_once '../models/User.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../page/error_admin.php");
    exit();
}

$users = User::getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    User::delete($_POST['id']);
    header("Location: manage_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs</title>
</head>
<body>
    <h2>Gestion des utilisateurs</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['id']); ?></td>
            <td><?= htmlspecialchars($user['name']); ?></td>
            <td><?= htmlspecialchars($user['email']); ?></td>
            <td>
                 <!-- Pour supprimer un user -->
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $user['id']; ?>">
                    <button type="submit" name="delete" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="dashboard.php">Retour au tableau de bord</a>
</body>
</html>
