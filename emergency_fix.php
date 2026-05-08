<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'online_shop';

try {
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $db");
    $pdo->exec("USE $db");
    
    echo "Creating users... ";
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50), password VARCHAR(255), email VARCHAR(100), role VARCHAR(20))");
    echo "Done.<br>";
    
    echo "Creating products... ";
    $pdo->exec("CREATE TABLE IF NOT EXISTS products (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100), description TEXT, price DECIMAL(10,2), stock_quantity INT)");
    echo "Done.<br>";
    
    echo "Creating categories... ";
    $pdo->exec("CREATE TABLE IF NOT EXISTS categories (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100))");
    echo "Done.<br>";

    echo "Creating orders... ";
    $pdo->exec("CREATE TABLE IF NOT EXISTS orders (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT, total_amount DECIMAL(10,2), status VARCHAR(20))");
    echo "Done.<br>";

    echo "<h1>All tables created!</h1>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
