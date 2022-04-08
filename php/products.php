<?php
$pdo = new PDO("mysql:host=localhost;", "root", "mysql");
$dbName = "DefaultCube";
$currentDir = "../";
$pdo->query("use $dbName");

$query = "SELECT * FROM products";
$stmt = $pdo->query($query);
if ($stmt->rowCount() > 0) {
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        echo
        "<div class='card'><div class='card-image' style='background-image: url(" . $currentDir . $row['img'] . ");'></div>
        <div class='card-text'>
            <h1>" . $row['nome'] . "</h1>
            <p>" . $row['prezzo'] . "$</p>
        </div>";
    }
}