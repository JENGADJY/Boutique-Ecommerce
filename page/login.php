<?php

session_start();
require_once '../config/database.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, name, email, role, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role']
        ];



        $redirect = isset($_SESSION['redirect_after_login']) ? $_SESSION['redirect_after_login'] : '../index.php';
        unset($_SESSION['redirect_after_login']);
        header("Location: " . $redirect);
        exit();
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Connexion</h2>
    
    <?php if (isset($error)) : ?>
        <p style="color:red;"><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>
    
    <form method="POST" action="">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit" name="login">Se connecter</button>
    </form>
</body>
</html>
