<?php
try{
    $pdo = new PDO("mysql:host=localhost;","root","mysql");
    $dbName = "DefaultCube";

    $sqlTables = [
        "CREATE TABLE account(
            username VARCHAR(30) PRIMARY KEY,
            nome TEXT NOT NULL,
            surname TEXT NOT NULL,
            email TEXT NOT NULL,
            pass TEXT NOT NULL
        )",
        "CREATE TABLE products(
            id_prod INT PRIMARY KEY,
            nome TEXT NOT NULL,
            prezzo DOUBLE NOT NULL,
            img TEXT NOT NULL
        )",
        "CREATE TABLE cart(
            username VARCHAR(30) PRIMARY KEY,
            id_prod INT PRIMARY KEY,
        )"
    ];

    $verifica= $pdo->query("use $dbName"); //se non trova nulla il valore è False
    if(!$verifica){
        $pdo->query("CREATE DATABASE $dbName");
        $pdo->query("use $dbName");
        foreach($sqlTables as $table){
            $pdo->query($table);
        }
        
    }
}
catch (PDOExepction $err){
    echo ($err);
}
?>