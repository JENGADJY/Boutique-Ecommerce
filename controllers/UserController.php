<?php
require_once '../models/User.php';

session_start();
#Creation d'un utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        if (User::register($_POST['name'], $_POST['email'], $_POST['password'])) {
            header("Location: ../page/login.php");
            exit();
        }
    }
    #Connection d'un utilisateur
    if (isset($_POST['login'])) {
        $user = User::login($_POST['email'], $_POST['password']);
        if ($user) {
            $_SESSION['user'] = $user;
            header("Location: ../page/index.php");
            exit();
        }
    }
}
?>
