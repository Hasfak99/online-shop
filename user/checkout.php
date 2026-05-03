
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Checkout | Online Shop</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body style="display: flex; align-items: center; justify-content: center; min-height: 100vh;">

    <div class="container" style="max-width: 600px;">
        <?php if ($success): ?>
            <div class="card" style="text-align: center;">
                <h2 style="color: #4ade80;">Order Placed Successfully!</h2>
                <p style="margin: 1.5rem 0; color: var(--text-dim);">Thank you for shopping. Your artisan pieces are being
                    prepared.</p>
                <a href="orders.php" class="btn btn-primary">View My Orders</a>
            </div>
        <?php else: ?>
            <div class="card">
                <h2>Confirm Your Order</h2>
                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo $error; ?></div>
                <?php endif; ?>
                <p style="margin-bottom: 2rem; color: var(--text-dim);">By clicking 'Confirm Order', your purchase will be
                    processed immediately.</p>
                <form method="POST">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Confirm Order</button>
                </form>
                <a href="cart.php"
                    style="display: block; text-align: center; margin-top: 1rem; color: var(--text-dim); text-decoration: none;">Go
                    back to cart</a>
            </div>
        <?php endif; ?>
    </div>

</body>

</html>