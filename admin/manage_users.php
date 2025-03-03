<?php
session_start();
require_once '../config/database.php';
require_once '../models/User.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../page/error_admin.php");
    exit();
}

$users = User::getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        User::delete($_POST['id']);
        header("Location: manage_users.php");
        exit();
    }

    if (isset($_POST['change_role'])) {
        $userId = $_POST['id'];
        $newRole = $_POST['new_role'];
        User::updateRole($userId, $newRole);
        header("Location: manage_users.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs</title>
    <link rel="stylesheet" href="../css/manage_users.css">
</head>
<body>
    <div class="container">
        <h2>Gestion des utilisateurs</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']); ?></td>
                <td><?= htmlspecialchars($user['name']); ?></td>
                <td><?= htmlspecialchars($user['email']); ?></td>
                <td><?= htmlspecialchars($user['role']); ?></td>
                <td>
                    <!-- Supprimer un utilisateur -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $user['id']; ?>">
                        <button type="submit" name="delete" onclick="return confirm('Confirmer la suppression ?')">🗑 Supprimer</button>
                    </form>

                    <!-- Changer le rôle d'un utilisateur -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $user['id']; ?>">
                        <input type="hidden" name="new_role" value="<?= $user['role'] === 'admin' ? 'user' : 'admin'; ?>">
                        <button type="submit" name="change_role">
                            <?= $user['role'] === 'admin' ? '⬇ Rétrograder' : '⬆ Promouvoir'; ?>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <a href="dashboard.php" class="back-btn">Retour au tableau de bord</a>
    </div>
</body>
</html>
