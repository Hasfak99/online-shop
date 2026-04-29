<?php
require_once '../includes/functions.php';
requireAdmin();

// Fetch Sales Summary from View (Requirement: View used in PHP)
$sales_summary = $pdo->query("SELECT * FROM v_sales_by_category")->fetchAll();

// Fetch Low Stock Report from View (Requirement: View used in PHP)
$low_stock = $pdo->query("SELECT * FROM v_low_stock_report")->fetchAll();

// Complex Query using Aggregations and GROUP BY (Requirement: Meaningful complex query)
$top_customers = $pdo->query("
    SELECT u.username, COUNT(o.id) as total_orders, SUM(o.total_amount) as spent
    FROM users u
    JOIN orders o ON u.id = o.user_id
    WHERE o.status = 'completed'
    GROUP BY u.id
    ORDER BY spent DESC
    LIMIT 5
")->fetchAll();
