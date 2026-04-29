
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users | Online Shop</title>
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

    <div class="card">
        <h3>User Management</h3>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td><?php echo htmlspecialchars($u['username']); ?></td>
                    <td><?php echo htmlspecialchars($u['email']); ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="change_role">
                            <input type="hidden" name="id" value="<?php echo $u['id']; ?>">
                            <select name="role" onchange="this.form.submit()" style="padding: 0.25rem; border-radius: 0.25rem; border: 1px solid var(--glass-border); background: var(--bg-color); color: var(--text-color);">
                                <option value="user" <?php echo $u['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                                <option value="admin" <?php echo $u['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                            </select>
                        </form>
                    </td>
                    <td><?php echo date('M d, Y', strtotime($u['created_at'])); ?></td>
                    <td>
                        <?php if ($u['id'] != $_SESSION['user_id']): ?>
                        <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $u['id']; ?>">
                            <button type="submit" style="background:none; border:none; color:var(--error); cursor:pointer;">Delete</button>
                        </form>
                        <?php else: ?>
                        <span style="color: var(--text-dim); font-size: 0.85em;">Current User</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
