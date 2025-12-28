<?php
// setup_database.php

$host = getenv('DB_HOST') ?: "localhost";
$db_user = getenv('DB_USER') ?: "root";
$db_pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : "";
$db_name = getenv('DB_NAME') ?: "DefaultCube";

echo "Waiting for MySQL database at $host...\n";

// Retry logic for Docker containers (waiting for DB to be ready)
$maxRetries = 30;
$connected = false;

for ($i = 0; $i < $maxRetries; $i++) {
    try {
        $pdo = new PDO("mysql:host=$host", $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connected = true;
        break;
    } catch (PDOException $e) {
        echo "Waiting for database... (Attempt " . ($i + 1) . "/$maxRetries)\n";
        sleep(2);
    }
}

if (!$connected) {
    die("Error: Could not connect to MySQL database after multiple attempts.\n");
}

try {
    echo "Connected successfully. Creating database '$db_name' if it doesn't exist...\n";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name`");
    $pdo->exec("USE `$db_name`");
    
    $sqlTables = [
        "CREATE TABLE IF NOT EXISTS account(
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(30) UNIQUE,
            nome TEXT NOT NULL,
            surname TEXT NOT NULL,
            email TEXT NOT NULL,
            pass TEXT NOT NULL,
            tipo TEXT NOT NULL)",
        "CREATE TABLE IF NOT EXISTS products(
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome TEXT NOT NULL,
            prezzo DOUBLE NOT NULL,
            descr TEXT,
            img TEXT,
            vertices INT,
            weightMB DOUBLE,
            rating INT)",
        "CREATE TABLE IF NOT EXISTS productimages(
            id_img INT AUTO_INCREMENT PRIMARY KEY,
            nome TEXT NOT NULL,
            src TEXT NOT NULL,
            descr TEXT)",
        "CREATE TABLE IF NOT EXISTS ordini(
            username VARCHAR(30),
            id_prod INT,
            rating INT,
            nome TEXT,
            descr TEXT,
            PRIMARY KEY(username, id_prod))",
    ];

    foreach ($sqlTables as $table) {
        $pdo->exec($table);
        echo "Table processed.\n";
    }

    // Check if admin exists before inserting
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM account WHERE username = ?");
    $stmt->execute(['admin']);
    if ($stmt->fetchColumn() == 0) {
        $sqlInsert = "INSERT INTO account(username, nome, surname, email, pass, tipo) VALUES ('admin', 'admin', 'admin', 'admin', '" . md5('admin') . "', 'admin')";
        $pdo->exec($sqlInsert);
        echo "Default admin user created.\n";
    } else {
        echo "Admin user already exists.\n";
    }
    
    $stmt->execute(['admin2']);
    if ($stmt->fetchColumn() == 0) {
         $sqlInsert = "INSERT INTO account(username, nome, surname, email, pass, tipo) VALUES ('admin2', 'admin2', 'admin2', 'admin2', '" . md5('admin2') . "', 'admin2')";
         $pdo->exec($sqlInsert);
         echo "Default admin2 user created.\n";
    }

    echo "Database setup completed successfully.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
