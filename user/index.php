<?php
require_once '../includes/functions.php';
requireLogin();

// Fetch products for the shop
$products = $pdo->query("
    SELECT p.*, c.name as category_name 
    FROM products p 
    JOIN categories c ON p.category_id = c.id
    WHERE p.stock_quantity > 0
    ORDER BY p.name ASC
")->fetchAll();

?>
