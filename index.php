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
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 80ab4c27ba0ff1489064c97c1d683542f2bda3b5
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Shop | Shop Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body style="display: flex; align-items: center; justify-content: center; min-height: 100vh; background: radial-gradient(circle at top left, #1e293b, #0b1326);">

<div class="card" style="width: 100%; max-width: 400px;">
    <h1 style="text-align: center; background: linear-gradient(to right, #b8c4ff, #ddb8ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Online Shop</h1>
    <p style="text-align: center; color: var(--text-dim); margin-bottom: 2rem;">Access your artisan collection dashboard.</p>

    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Username</label>
<<<<<<< HEAD
            <input type="text" name="username" onpaste="return false;" oncopy="return false;" oncut="return false;" required>
=======
            <input type="text" name="username" required>
>>>>>>> 80ab4c27ba0ff1489064c97c1d683542f2bda3b5
        </div>

        <div class="form-group">
            <label>Password</label>
<<<<<<< HEAD
            <input type="password" name="password" onpaste="return false;" oncopy="return false;" oncut="return false;" required>
=======
            <input type="password" name="password" required>
>>>>>>> 80ab4c27ba0ff1489064c97c1d683542f2bda3b5
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Login</button>
    </form>
    
    <div style="text-align: center; margin-top: 1.5rem; font-size: 0.875rem;">
        <span style="color: var(--text-dim);">Don't have an account?</span> 
        <a href="register.php" style="color: var(--primary); text-decoration: none; font-weight: 500;">Register Now</a>
    </div>
</div>

</body>
</html>
<<<<<<< HEAD
=======
=======
>>>>>>> origin/authentication-core-logic
>>>>>>> 80ab4c27ba0ff1489064c97c1d683542f2bda3b5
