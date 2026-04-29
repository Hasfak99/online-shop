<?php
require_once '../includes/functions.php';
requireAdmin();

if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit;
}

$id = $_GET['id'];

// Fetch the product
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    setFlash('Product not found.', 'error');
    header("Location: products.php");
    exit;
}

// Handling Update Operation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'edit') {
        $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock_quantity = ?, category_id = ? WHERE id = ?");
        $stmt->execute([$_POST['name'], $_POST['description'], $_POST['price'], $_POST['stock'], $_POST['category_id'], $id]);
        setFlash('Product updated successfully', 'success');
        header("Location: products.php");
        exit;
    }
}

// Fetch Categories for dropdown
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
?>
