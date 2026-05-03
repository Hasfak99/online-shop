<?php
require_once '../includes/functions.php';
requireLogin();

if (empty($_SESSION['cart'])) {
    header('Location: index.php');
    exit();
}

$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    try {
        $pdo->beginTransaction();

        // 1. Call Stored Procedure for Order (Requirement: Procedure + Transaction)
        $stmt = $pdo->prepare("CALL sp_place_order(?, ?)");
        $stmt->execute([$_SESSION['user_id'], $total]);
        $order = $stmt->fetch();
        $order_id = $order['order_id'];
        $stmt->closeCursor();

        // 2. Insert Order Items and Update Stock
        foreach ($_SESSION['cart'] as $product_id => $item) {
            // Insert item
            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)");
            $stmt->execute([$order_id, $product_id, $item['quantity'], $item['price']]);

            // Update stock (Requirement: Procedure called in PHP)
            $stmt = $pdo->prepare("CALL sp_update_stock(?, ?)");
            $stmt->execute([$product_id, -$item['quantity']]); // Negative to decrease
            $stmt->closeCursor();
        }

        if ($pdo->inTransaction()) {
            $pdo->commit();
        }
        $_SESSION['cart'] = [];
        $success = true;
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $error = "Checkout failed: " . $e->getMessage();
    }
}
?>
