<?php
try{
    $pdo = new PDO("mysql:host=localhost;","root","mysql");
    $dbName = "DefaultCube";

    $sqlTables = [
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
    foreach($sqlTables as $table){
        $pdo->query($table);
    }
    $sqlInsert = "INSERT INTO account(username, nome, surname, email, pass, tipo) value('admin', 'admin', 'admin', 'admin', 'admin', 'admin')";
    $sqlInsert = "INSERT INTO account(username, nome, surname, email, pass, tipo) value('admin2', 'admin2', 'admin2', 'admin2', 'admin2', 'admin2')";
    $pdo->query($sqlInsert);
}
catch (PDOExepction $err){
    echo ($err);
}
?>