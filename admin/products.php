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
<<<<<<< HEAD
        try {
            // Soft Delete: Instead of removing the row, we mark it as deleted
            // This preserves order history for reports
            $stmt = $pdo->prepare("UPDATE products SET is_deleted = 1 WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            setFlash('Product archived successfully', 'success');
        } catch (PDOException $e) {
            setFlash('Error archiving product: ' . $e->getMessage(), 'error');
        }
=======
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$_POST['id']]);
        setFlash('Product deleted', 'success');
>>>>>>> 80ab4c27ba0ff1489064c97c1d683542f2bda3b5
    }
}

// Fetch Categories for dropdown
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

// Fetch Products with Category Name (Requirement: JOIN query)
$products = $pdo->query("
    SELECT p.*, c.name as category_name 
    FROM products p 
    LEFT JOIN categories c ON p.category_id = c.id
<<<<<<< HEAD
    WHERE p.is_deleted = 0
    ORDER BY p.created_at DESC
")->fetchAll();
?>
=======
    ORDER BY p.created_at DESC
")->fetchAll();
?>

>>>>>>> 80ab4c27ba0ff1489064c97c1d683542f2bda3b5
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products | Online Shop</title>
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

    <div class="grid" style="grid-template-columns: 1fr 2fr; align-items: start;">
        <!-- Add Product Form -->
        <div class="card">
            <h3>Add New Product</h3>
            <form method="POST">
                <input type="hidden" name="action" value="add">
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Price ($)</label>
                    <input type="number" step="0.01" name="price" required>
                </div>
                <div class="form-group">
                    <label>Initial Stock</label>
                    <input type="number" name="stock" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Save Product</button>
            </form>
        </div>

        <!-- Products Table -->
        <div class="card">
            <h3>Product Inventory</h3>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($p['name']); ?></td>
                        <td><?php echo htmlspecialchars($p['category_name']); ?></td>
                        <td>$<?php echo number_format($p['price'], 2); ?></td>
                        <td><span style="color: <?php echo $p['stock_quantity'] < 10 ? 'var(--error)' : 'inherit'; ?>"><?php echo $p['stock_quantity']; ?></span></td>
                        <td>
                            <a href="edit_product.php?id=<?php echo $p['id']; ?>" style="color:var(--primary); margin-right: 10px; text-decoration: none;">Edit</a>
<<<<<<< HEAD
                            <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
=======
                            <form method="POST" style="display:inline;">
>>>>>>> 80ab4c27ba0ff1489064c97c1d683542f2bda3b5
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                                <button type="submit" style="background:none; border:none; color:var(--error); cursor:pointer;">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
