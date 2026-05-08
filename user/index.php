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
<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Shop | Shop</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<nav>
    <h2 style="margin: 0; color: var(--primary);">Online Shop</h2>
    <div class="nav-links">
        <a href="index.php">Shop</a>
        <a href="orders.php">My Orders</a>
        <a href="cart.php">Cart (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a>
        <a href="../logout.php">Logout</a>
    </div>
</nav>

<div class="container">
    <form action="cart.php" method="POST">
        <input type="hidden" name="action" value="add_multiple">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
            <div>
                <h1>Exquisite Collections</h1>
                <p style="color: var(--text-dim);">Discover our curated selection of premium products.</p>
            </div>
            <button type="submit" class="btn btn-primary">Add Selected to Cart</button>
        </div>

        <div class="grid">
            <?php foreach ($products as $p): ?>
            <div class="card" style="padding: 1.5rem; transition: transform 0.3s ease; position: relative;">
                <input type="checkbox" name="product_ids[]" value="<?php echo $p['id']; ?>" style="position: absolute; top: 1.5rem; right: 1.5rem; width: 1.2rem; height: 1.2rem; cursor: pointer; accent-color: var(--primary);">
                <div style="height: 150px; border-radius: 1rem; margin-bottom: 1rem; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                    <?php 
                        $img_src = '../assets/img/smartphone.png'; // default
                        $cat = strtolower($p['category_name']);
                        $name = strtolower($p['name']);
                        if (strpos($cat, 'clothing') !== false || strpos($name, 'shirt') !== false) {
                            $img_src = '../assets/img/clothing.png';
                        } elseif (strpos($cat, 'electronic') !== false && strpos($name, 'headphone') === false) {
                            $img_src = '../assets/img/smartphone.png';
                        } elseif (strpos($name, 'headphone') !== false) {
                            $img_src = '../assets/img/headphones.png';
                        }
                    ?>
                    <img src="<?php echo $img_src; ?>" alt="<?php echo htmlspecialchars($p['name']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <label><?php echo htmlspecialchars($p['category_name']); ?></label>
                <h3 style="margin: 0.5rem 0;"><?php echo htmlspecialchars($p['name']); ?></h3>
                <p style="color: var(--text-dim); font-size: 0.875rem; height: 3rem; overflow: hidden;"><?php echo htmlspecialchars($p['description']); ?></p>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem;">
                    <span style="font-size: 1.25rem; font-weight: 600; color: var(--primary);">$<?php echo number_format($p['price'], 2); ?></span>
                    <button type="submit" name="single_product_id" value="<?php echo $p['id']; ?>" class="btn btn-outline" style="padding: 0.5rem 1rem;">Add to Cart</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </form>
</div>

</body>
</html>
=======
>>>>>>> 80ab4c27ba0ff1489064c97c1d683542f2bda3b5
