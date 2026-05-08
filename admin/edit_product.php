<?php
require_once '../includes/functions.php';
requireAdmin();

if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit;
}

$id = $_GET['id'];

// Fetch the product
<<<<<<< HEAD
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? AND is_deleted = 0");
=======
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
>>>>>>> 80ab4c27ba0ff1489064c97c1d683542f2bda3b5
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
<<<<<<< HEAD
=======

>>>>>>> 80ab4c27ba0ff1489064c97c1d683542f2bda3b5
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product | Online Shop</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<nav>
    <h2 style="margin: 0; color: var(--primary);">Online Shop Admin</h2>
    <div class="nav-links">
        <a href="dashboard.php">Dashboard</a>
        <a href="products.php">Products</a>
        <a href="users.php">Users</a>
        <a href="reports.php">Reports</a>
        <a href="../logout.php">Logout</a>
    </div>
</nav>

<div class="container">
    <?php displayFlash(); ?>

    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <h3>Edit Product</h3>
        <form method="POST">
            <input type="hidden" name="action" value="edit">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category_id">
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo $cat['id'] == $product['category_id'] ? 'selected' : ''; ?>><?php echo $cat['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Price ($)</label>
                <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            </div>
            <div class="form-group">
                <label>Stock Quantity</label>
                <input type="number" name="stock" value="<?php echo htmlspecialchars($product['stock_quantity']); ?>" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="5"><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">Update Product</button>
                <a href="products.php" class="btn" style="flex: 1; text-align: center; background: #eee; color: #333; text-decoration: none;">Cancel</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
