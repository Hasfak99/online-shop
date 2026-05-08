<?php
require_once 'includes/functions.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Server-side validation (Requirement: Server-side validation on all forms)
    if (empty($username) || empty($email) || empty($password)) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } else {
        // Check if username or email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $error = 'Username or Email already exists.';
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')");
            if ($stmt->execute([$username, $email, $hashed_password])) {
                $success = 'Registration successful! You can now login.';
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Join Online Shop | Registration</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body style="display: flex; align-items: center; justify-content: center; min-height: 100vh; background: radial-gradient(circle at top left, #1e293b, #0b1326);">

<div class="card" style="width: 100%; max-width: 450px;">
    <h2 style="text-align: center; color: var(--primary);">Create Account</h2>
    <p style="text-align: center; color: var(--text-dim); margin-bottom: 2rem;">Join our community of artisan collectors.</p>

    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert" style="background: rgba(74, 222, 128, 0.1); color: #4ade80; border: 1px solid #4ade80;"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" onpaste="return false;" oncopy="return false;" oncut="return false;" required>
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" onpaste="return false;" oncopy="return false;" oncut="return false;" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" onpaste="return false;" oncopy="return false;" oncut="return false;" required>
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" onpaste="return false;" oncopy="return false;" oncut="return false;" required>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Register</button>
    </form>
    
    <div style="text-align: center; margin-top: 1.5rem; font-size: 0.875rem;">
        <span style="color: var(--text-dim);">Already have an account?</span> 
        <a href="index.php" style="color: var(--primary); text-decoration: none; font-weight: 500;">Login here</a>
    </div>
</div>

</body>
</html>
