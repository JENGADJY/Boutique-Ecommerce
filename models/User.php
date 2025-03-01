<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ecommerce/config/database.php';

class User {
    public static function register($name, $email, $password) {
        global $conn;
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $email, $hash]);
    }

    public static function login($email, $password) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public static function getAll() {
        global $conn;
        $stmt = $conn->query("SELECT id, name,role ,email FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function delete($id) {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
}
?>
