<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="../css/register.css">
</head>
<body>
    <div class="container">
        <h2>Inscription</h2>
        
        <?php if (isset($_GET['error'])): ?>
            <p style="color: red; text-align: center;"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
        
        <!-- Formulaire d'inscription -->
        <form method="POST" action="../controllers/UserController.php">
            <input type="text" name="name" placeholder="Nom" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit" name="register">S'inscrire</button>
        </form>

        <p style="text-align: center; color: #ebf4fb;">
            Vous avez déjà un compte ? <a href="../page/login.php">Connectez-vous ici</a>
        </p>
    </div>
</body>
</html>
