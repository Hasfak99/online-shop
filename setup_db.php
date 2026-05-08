<?php
/**
 * Database Setup Script
 * Run this script once to initialize the 'online_shop' database.
 * URL: http://localhost/online-shop/setup_db.php
 */

$host = 'localhost';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Initial connection without database name
$dsn = "mysql:host=$host;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "<h1>Database Setup</h1>";
    echo "<p>Connected to MySQL server successfully.</p>";

    // 1. Create Database
    $pdo->exec("DROP DATABASE IF EXISTS online_shop");
    $pdo->exec("CREATE DATABASE online_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<p style='color: green;'>✔ Database 'online_shop' created or already exists.</p>";

    // 2. Select the database
    $pdo->exec("USE online_shop");

    // 3. Import SQL files
    $sqlFiles = [
        'sql/schema.sql' => 'Schema (Tables)',
        'sql/data.sql'   => 'Sample Data',
        'sql/logic.sql'  => 'Logic (Procedures/Triggers)'
    ];

    foreach ($sqlFiles as $file => $description) {
        $filePath = __DIR__ . DIRECTORY_SEPARATOR . $file;
        if (file_exists($filePath)) {
            $sql = file_get_contents($filePath);
            
            echo "<h3>Importing $description...</h3>";
            
            // Handle DELIMITER commands
            // 1. Remove comments
            $sql = preg_replace('/--.*$/m', '', $sql);
            
            // 2. Look for DELIMITER blocks
            if (stripos($sql, 'DELIMITER') !== false) {
                // This is a bit complex for a simple script, so we'll try to split by the common // delimiter
                $parts = preg_split('/DELIMITER\s+(\S+)/i', $sql, -1, PREG_SPLIT_DELIM_CAPTURE);
                
                for ($i = 0; $i < count($parts); $i++) {
                    $content = trim($parts[$i]);
                    if (empty($content)) continue;
                    
                    if ($i + 1 < count($parts) && strlen($parts[$i+1]) <= 2) {
                        $delimiter = $parts[$i+1];
                        $statements = explode($delimiter, $parts[$i+2]);
                        foreach ($statements as $stmt) {
                            $stmt = trim($stmt);
                            if (!empty($stmt)) {
                                try {
                                    $pdo->exec($stmt);
                                } catch (PDOException $e) {
                                    echo "<p style='color: red;'>Error in statement: " . htmlspecialchars(substr($stmt, 0, 50)) . "... <br>" . $e->getMessage() . "</p>";
                                }
                            }
                        }
                        $i += 2; // Skip delimiter and content
                    } else {
                        // Standard semicolon split
                        $statements = explode(';', $content);
                        foreach ($statements as $stmt) {
                            $stmt = trim($stmt);
                            if (!empty($stmt)) {
                                try {
                                    $pdo->exec($stmt);
                                } catch (PDOException $e) {
                                    echo "<p style='color: red;'>Error in statement: " . htmlspecialchars(substr($stmt, 0, 50)) . "... <br>" . $e->getMessage() . "</p>";
                                }
                            }
                        }
                    }
                }
            } else {
                // Standard semicolon split
                $statements = explode(';', $sql);
                foreach ($statements as $stmt) {
                    $stmt = trim($stmt);
                    if (!empty($stmt)) {
                        try {
                            $pdo->exec($stmt);
                        } catch (PDOException $e) {
                            echo "<p style='color: red;'>Error in statement: " . htmlspecialchars(substr($stmt, 0, 50)) . "... <br>" . $e->getMessage() . "</p>";
                        }
                    }
                }
            }
            echo "<p style='color: green;'>✔ $description processing finished.</p>";
        } else {
            echo "<p style='color: orange;'>⚠ Warning: File $file not found. Skipping.</p>";
        }
    }

    echo "<hr><p><strong>Setup complete!</strong> You can now use the application.</p>";
    echo "<p><a href='index.php'>Go to Homepage</a></p>";

} catch (PDOException $e) {
    echo "<h1>Setup Failed</h1>";
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    echo "<p>Please ensure XAMPP MySQL is running and the 'root' user has no password (or update this script).</p>";
}
