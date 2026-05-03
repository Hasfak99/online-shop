
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reports & Insights | Online Shop</title>
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
    <h1>Sales & Inventory Analytics</h1>

    <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 3rem;">
        <!-- Sales by Category (Aggregated) -->
        <div class="card">
            <h3>Revenue by Category</h3>
            <table>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Items Sold</th>
                        <th>Total Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sales_summary as $sale): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($sale['category_name']); ?></td>
                        <td><?php echo $sale['items_sold']; ?></td>
                        <td>$<?php echo number_format($sale['total_sales'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Top Customers (Complex Query) -->
        <div class="card">
            <h3>Top Valued Customers</h3>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Orders</th>
                        <th>Total Spent</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($top_customers as $cust): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($cust['username']); ?></td>
                        <td><?php echo $cust['total_orders']; ?></td>
                        <td>$<?php echo number_format($cust['spent'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Inventory Health -->
    <div class="card" style="border-color: var(--error);">
        <h3 style="color: var(--error);">Low Stock Alert (Stock < 10)</h3>
        <table>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Current Stock</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($low_stock)): ?>
                    <tr><td colspan="4" style="text-align:center;">All products are well stocked.</td></tr>
                <?php else: ?>
                    <?php foreach ($low_stock as $low): ?>
                    <tr>
                        <td>#<?php echo $low['id']; ?></td>
                        <td><?php echo htmlspecialchars($low['name']); ?></td>
                        <td style="color: var(--error); font-weight: bold;"><?php echo $low['stock_quantity']; ?></td>
                        <td>$<?php echo number_format($low['price'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
