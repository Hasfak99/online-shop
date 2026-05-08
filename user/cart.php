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
