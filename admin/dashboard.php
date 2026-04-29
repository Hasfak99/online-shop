<?php
require_once '../includes/functions.php';
requireAdmin();

// Call Stored Procedure for Stats (Requirement: Procedure called in PHP)
$stmt = $pdo->prepare("CALL sp_get_dashboard_stats()");
$stmt->execute();
$stats = $stmt->fetch();
$stmt->closeCursor(); // Essential when calling multiple procedures or queries after a procedure

// Query for Recent Orders (Requirement: JOIN query)
$orders_stmt = $pdo->query("
    SELECT o.id, u.username, o.order_date, o.total_amount, o.status 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    ORDER BY o.order_date DESC 
    LIMIT 5
");
$recent_orders = $orders_stmt->fetchAll();

?>
