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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders | Online Shop</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<nav>
    <h2 style="margin: 0; color: var(--primary);">Online Shop</h2>
    <div class="nav-links">
        <a href="index.php">Shop</a>
        <a href="orders.php">My Orders</a>
        <a href="cart.php">Cart</a>
        <a href="../logout.php">Logout</a>
    </div>
</nav>

<div class="container">
    <h1>Order History</h1>

    <?php if (empty($orders)): ?>
        <div class="card" style="text-align: center; padding: 4rem;">
            <h3 style="color: var(--text-dim);">You haven't placed any orders yet.</h3>
            <a href="index.php" class="btn btn-primary" style="margin-top: 1rem;">Start Shopping</a>
        </div>
    <?php else: ?>
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $o): ?>
                    <tr>
                        <td>#<?php echo $o['id']; ?></td>
                        <td><?php echo date('M d, Y H:i', strtotime($o['order_date'])); ?></td>
                        <td>$<?php echo number_format($o['total_amount'], 2); ?></td>
                        <td>
                            <span style="color: <?php 
                                echo $o['status'] === 'completed' ? '#4ade80' : ($o['status'] === 'cancelled' ? 'var(--error)' : '#fbbf24'); 
                            ?>;">
                                <?php echo ucfirst($o['status']); ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

</body>
</html>

