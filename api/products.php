<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/api/config/database.php';

// header("Access-Control-Allow-Origin: * ");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$currentDir = "../../";

$databaseService = new DatabaseService();
$pdo = $databaseService->getConnection();

$data = json_decode(file_get_contents("php://input"));

$query = "SELECT * FROM products";
$stmt = $pdo->query($query);
if ($stmt->rowCount() > 0) {
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        echo
        "<div class='card' onclick='fullScreen(this)' data-description='" . $row["descr"] . "' data-id='" . $row["id_prod"] . "'>
                <img  class='card-image' width='100%' src='" . $currentDir . $row['img'] . "'></img>
                <div class='card-text'>
                    <h1 style='margin-right:auto;'>" . $row['nome'] . "</h1>
                    <p>" . $row['prezzo'] . "$</p>
                </div>
            </div>";
    }
}