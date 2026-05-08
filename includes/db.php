<?php
// Database connection using PDO
$host = 'localhost';
$db   = 'online_shop';
$user = 'root';
$pass = ''; // Set your MySQL password here
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // If database doesn't exist (Error 1049), try to create it automatically
    if ($e->getCode() == 1049) {
        try {
            $temp_dsn = "mysql:host=$host;charset=$charset";
            $temp_pdo = new PDO($temp_dsn, $user, $pass, $options);
            $temp_pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            // Try connecting again
            $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e2) {
            throw new \PDOException("Failed to auto-create database: " . $e2->getMessage(), (int)$e2->getCode());
        }
    } else {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}
?>
