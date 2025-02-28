<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ecommerce/config/database.php';
class Product {
    private static function getConnection() {
        require $_SERVER['DOCUMENT_ROOT'] . '/ecommerce/config/database.php';
        return $conn;
    }

    public static function getAll() {
        $conn = self::getConnection();
        $stmt = $conn->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $conn = self::getConnection();
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function add($name, $description, $price, $stock) {
        $conn = self::getConnection();
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $description, $price, $stock]);
    }

    public static function delete($id) {
        $conn = self::getConnection();
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

?>
