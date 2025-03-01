<?php
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

    $sql = "
    -- Création de la table 'users'
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

    -- Table 'invoices'
    CREATE TABLE IF NOT EXISTS invoices (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT,
        user_id INT,
        total_price DECIMAL(10,2),
        billing_address VARCHAR(255),
        city VARCHAR(100),
        postal_code VARCHAR(20),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (order_id) REFERENCES orders(id),
        FOREIGN KEY (user_id) REFERENCES users(id)
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

    -- Insertion de données de test pour les utilisateurs
    INSERT INTO users (name, email, password, role) VALUES
    ('Admin', 'admin@admin.com', 'adminpassword', 'admin'),

    -- Insertion de produits de test
    INSERT INTO products (name, description, price, stock, image) VALUES
    ('Produit 1', 'Description du produit 1', 10.99, 100, 'product1.jpg'),
    ('Produit 2', 'Description du produit 2', 20.50, 50, 'product2.jpg'),
    ('Produit 3', 'Description du produit 3', 15.75, 30, 'product3.jpg');

    ";

    $conn->exec($sql);
    echo "Base de données initialisée avec succès !";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>