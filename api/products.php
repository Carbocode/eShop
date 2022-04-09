<?php
include_once './config/database.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$databaseService = new DatabaseService();
$pdo = $databaseService->getConnection();

$data = json_decode(file_get_contents("php://input"));

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