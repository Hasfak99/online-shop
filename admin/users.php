<?php
require_once '../includes/functions.php';
requireAdmin();

// Handling User Roles and Deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'delete' && isset($_POST['id'])) {
        // Prevent admin from deleting themselves
        if ($_POST['id'] != $_SESSION['user_id']) {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            setFlash('User deleted successfully', 'success');
        } else {
            setFlash('You cannot delete your own account.', 'error');
        }
    } elseif ($_POST['action'] === 'change_role' && isset($_POST['id']) && isset($_POST['role'])) {
        // Prevent admin from removing their own admin role
        if ($_POST['id'] != $_SESSION['user_id'] || $_POST['role'] === 'admin') {
            $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
            $stmt->execute([$_POST['role'], $_POST['id']]);
            setFlash('User role updated', 'success');
        } else {
            setFlash('You cannot remove your own admin privileges.', 'error');
        }
    }
}

// Fetch Users
$users = $pdo->query("SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC")->fetchAll();
?>
