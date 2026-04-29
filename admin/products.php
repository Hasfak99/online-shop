<?php
require_once '../includes/functions.php';
requireAdmin();

// Handling CRUD Operations
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add') {
        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, stock_quantity, category_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['name'], $_POST['description'], $_POST['price'], $_POST['stock'], $_POST['category_id']]);
        setFlash('Product added successfully', 'success');
    } elseif ($_POST['action'] === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$_POST['id']]);
        setFlash('Product deleted', 'success');
    }
}

// Fetch Categories for dropdown
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

// Fetch Products with Category Name (Requirement: JOIN query)
$products = $pdo->query("
    SELECT p.*, c.name as category_name 
    FROM products p 
    LEFT JOIN categories c ON p.category_id = c.id
    ORDER BY p.created_at DESC
")->fetchAll();
?>
