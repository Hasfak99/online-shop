<?php
require_once '../includes/functions.php';
requireLogin();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Action Handler
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add' || $_POST['action'] === 'add_multiple') {
        $product_ids = [];
        if (isset($_POST['single_product_id'])) {
            $product_ids[] = $_POST['single_product_id'];
        } elseif (isset($_POST['product_ids']) && is_array($_POST['product_ids'])) {
            $product_ids = $_POST['product_ids'];
        } elseif (isset($_POST['product_id'])) {
            $product_ids[] = $_POST['product_id'];
        }

        foreach ($product_ids as $product_id) {
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch();
            
            if ($product) {
                if (isset($_SESSION['cart'][$product_id])) {
                    $_SESSION['cart'][$product_id]['quantity']++;
                } else {
                    $_SESSION['cart'][$product_id] = [
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'quantity' => 1
                    ];
                }
            }
        }
    } elseif ($_POST['action'] === 'remove') {
        unset($_SESSION['cart'][$_POST['product_id']]);
    }
    header('Location: cart.php');
    exit();
}

$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Cart | Online Shop</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<nav>
    <h2 style="margin: 0; color: var(--primary);">Online Shop</h2>
    <div class="nav-links">
        <a href="index.php">Shop</a>
        <a href="orders.php">My Orders</a>
        <a href="cart.php">Cart (<?php echo count($_SESSION['cart']); ?>)</a>
        <a href="../logout.php">Logout</a>
    </div>
</nav>

<div class="container">
    <h1>Your Shopping Cart</h1>

    <?php if (empty($_SESSION['cart'])): ?>
        <div class="card" style="text-align: center; padding: 4rem;">
            <h3 style="color: var(--text-dim);">Your cart is empty.</h3>
            <a href="index.php" class="btn btn-primary" style="margin-top: 1rem;">Go Shopping</a>
        </div>
    <?php else: ?>
        <div class="grid" style="grid-template-columns: 2fr 1fr;">
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                    <button type="submit" style="background:none; border:none; color:var(--error); cursor:pointer;">Remove</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="card">
                <h3>Order Summary</h3>
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                    <span>Subtotal</span>
                    <span>$<?php echo number_format($total, 2); ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 2rem; font-size: 1.25rem; font-weight: 600; color: var(--primary);">
                    <span>Total</span>
                    <span>$<?php echo number_format($total, 2); ?></span>
                </div>
                <a href="checkout.php" class="btn btn-primary" style="display: block; text-align: center; text-decoration: none; width: 100%; box-sizing: border-box;">Proceed to Checkout</a>
            </div>
        </div>
    <?php endif; ?>
</div>

</body>
</html>

