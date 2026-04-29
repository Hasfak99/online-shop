<?php
require_once 'includes/functions.php';

if (isLoggedIn()) {
    header('Location: ' . (isAdmin() ? 'admin/dashboard.php' : 'user/index.php'));
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = 'Please fill in all fields.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            header('Location: ' . ($user['role'] === 'admin' ? 'admin/dashboard.php' : 'user/index.php'));
            exit();
        } else {
            $error = 'Invalid username or password.';
        }
    }
}
?>
