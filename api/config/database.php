<?php

class DatabaseService
{
    private $db_host = "localhost";
    private $db_name = "DefaultCube";
    private $db_user = "root";
    private $db_password = "mysql";
    private $connection;

    public function getConnection()
    {

        $this->connection = null;

        try {
            $this->connection = new PDO("mysql:host=" . $this->db_host . ";dbname=" . $this->db_name, $this->db_user, $this->db_password);
        } catch (PDOException $exception) {
            echo "Connection failed: " . $exception->getMessage();
        }

        return $this->connection;
    }
}

/*$sqlTables = [
    "CREATE TABLE IF NOT EXISTS account(
        username VARCHAR(30) PRIMARY KEY,
        nome TEXT NOT NULL,
        surname TEXT NOT NULL,
        email TEXT NOT NULL,
        pass TEXT NOT NULL,
        tipo TEXT NOT NULL)",
    "CREATE TABLE IF NOT EXISTS products(
        id_prod INT PRIMARY KEY,
        nome TEXT NOT NULL,
        prezzo DOUBLE NOT NULL,
        img TEXT NOT NULL,
        descr TEXT,
        vertices INT,
        weightMB DOUBLE,
        rating INT)",
    "CREATE TABLE IF NOT EXISTS ordini(
        username VARCHAR(30),
        id_prod INT,
        rating INT,
        PRIMARY KEY(username, id_prod))",
    "CREATE TABLE IF NOT EXISTS popularity(
        id_prod INT PRIMARY KEY,
        views INT,
        downloads INT)",
];

$pdo->query("CREATE DATABASE IF NOT EXISTS $dbName");
$pdo->query("use $dbName");
foreach ($sqlTables as $table) {
    $pdo->query($table);
}
$sqlInsert = "INSERT INTO account(username, nome, surname, email, pass, tipo) value('admin', 'admin', 'admin', 'admin', 'admin', 'admin')";
$sqlInsert = "INSERT INTO account(username, nome, surname, email, pass, tipo) value('admin2', 'admin2', 'admin2', 'admin2', 'admin2', 'admin2')";
$pdo->query($sqlInsert);*/