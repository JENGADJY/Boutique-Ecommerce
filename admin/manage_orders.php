<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['users']) || $_SESSION['users']['role'] !== 'admin') {
    header("Location: ../page/error_admin.php");
    exit();
}

$stmt = $conn->query("SELECT orders.id, users.name AS user_name, orders.total_price, orders.status 
                      FROM orders 
                      JOIN users ON orders.user_id = users.id");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$new_status, $order_id]);

    header("Location: manage_orders.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des commandes</title>
</head>
<body>
    <h2>Gestion des commandes</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Client</th>
            <th>Total</th>
            <th>Statut</th>
            <th>Action</th>
        </tr>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= $order['id']; ?></td>
            <td><?= htmlspecialchars($order['user_name']); ?></td>
            <td><?= $order['total_price']; ?>€</td>
            <td><?= $order['status']; ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                    <select name="status">
                        <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : ''; ?>>En attente</option>
                        <option value="paid" <?= $order['status'] == 'paid' ? 'selected' : ''; ?>>Payé</option>
                        <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : ''; ?>>Expédié</option>
                    </select>
                    <button type="submit" name="update_status">Modifier</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="dashboard.php">Retour au tableau de bord</a>
</body>
</html>
