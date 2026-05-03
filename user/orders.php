<?php
require_once '../includes/functions.php';
requireLogin();

// Fetch order history for the user (Requirement: JOIN query)
$stmt = $pdo->prepare("
    SELECT o.id, o.order_date, o.total_amount, o.status
    FROM orders o
    WHERE o.user_id = ?
    ORDER BY o.order_date DESC
");
$stmt->execute([$_SESSION['user_id']]);
$orders = $stmt->fetchAll();

?>
