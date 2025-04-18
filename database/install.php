<?php
# Connexion à la database
$host = 'localhost'; 
$user = 'root';     
$password = '';      
$dbname = 'ecommerce'; 

try {
    $conn = new PDO("mysql:host=$host", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    echo "Base de données créée ou déjà existante.<br>";

    $conn->exec("USE $dbname");

    # Création des tables
    $sql = "
    -- Table 'users'
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('user', 'admin') DEFAULT 'user',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    -- Table 'products'
    CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        price DECIMAL(10,2) NOT NULL,
        stock INT NOT NULL DEFAULT 0,
        image VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    -- Table 'orders'
    CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        total_price DECIMAL(10,2),
        status ENUM('pending', 'paid', 'shipped') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    );

    -- Table 'order_items'
    CREATE TABLE IF NOT EXISTS order_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT,
        product_id INT,
        quantity INT,
        subtotal DECIMAL(10,2),
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
    );

    -- Table 'cart'
    CREATE TABLE IF NOT EXISTS cart (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        product_id INT,
        quantity INT,
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE, 
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    );
    ";

    $conn->exec($sql);
    echo "Tables créées avec succès.<br>";

    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = 'admin@admin.com'");
    $stmt->execute();
    $adminExists = $stmt->fetchColumn();

    if (!$adminExists) {
        $hashedPassword = password_hash('adminpassword', PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES ('Admin', 'admin@admin.com', :password, 'admin')");
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();

        echo "Compte administrateur créé avec succès.<br>";
    } else {
        echo "Le compte administrateur existe déjà.<br>";
    }

    echo "Base de données initialisée avec succès !";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
