
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Online Shop</title>
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
    <div class="grid" style="grid-template-columns: repeat(4, 1fr); margin-bottom: 3rem;">
        <div class="card" style="padding: 1.5rem; text-align: center;">
            <label>Products</label>
            <h2 style="margin: 0; color: var(--primary);"><?php echo $stats['total_products']; ?></h2>
        </div>
        <div class="card" style="padding: 1.5rem; text-align: center;">
            <label>Orders</label>
            <h2 style="margin: 0; color: var(--primary);"><?php echo $stats['total_orders']; ?></h2>
        </div>
        <div class="card" style="padding: 1.5rem; text-align: center;">
            <label>Revenue</label>
            <h2 style="margin: 0; color: var(--primary);">$<?php echo number_format($stats['total_revenue'] ?? 0, 2); ?></h2>
        </div>
        <div class="card" style="padding: 1.5rem; text-align: center;">
            <label>Customers</label>
            <h2 style="margin: 0; color: var(--primary);"><?php echo $stats['total_customers']; ?></h2>
        </div>
    </div>

    <div class="card">
        <h3>Recent Orders</h3>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recent_orders as $order): ?>
                <tr>
                    <td>#<?php echo $order['id']; ?></td>
                    <td><?php echo htmlspecialchars($order['username']); ?></td>
                    <td><?php echo date('M d, Y', strtotime($order['order_date'])); ?></td>
                    <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                    <td><span style="color: <?php echo $order['status'] === 'completed' ? '#4ade80' : '#fbbf24'; ?>;"><?php echo ucfirst($order['status']); ?></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
