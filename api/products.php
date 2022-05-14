<?php
include_once '../api/config/database.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$currentDir = "../../";

$alertError = "";
$alertSuccess = "";
$products = "";

$databaseService = new DatabaseService();
$pdo = $databaseService->getConnection();

$data = json_decode(file_get_contents("php://input"));

$query = "SELECT * FROM products";
$stmt = $pdo->query($query);
if ($stmt->rowCount() > 0) {
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {

        $products = $products .
            "<div class='card' onclick='fullScreen(this)' data-description='" . $row["descr"] . "' data-id='" . $row["id_prod"] . "'>
                <figure>
                    <img  class='card-image' src='" . $currentDir . $row['img'] . "'></img>
                    <figcaption class='card-text'>
                        <p>" . $row['nome'] . "</p>
                        <h4 class='card-price'>" . $row['prezzo'] . "$</h4>
                    </figcaption>
                </figure>
            </div>";
    }
}

if (empty(trim($alertError))) {
    echo json_encode(
        array(
            "alert" => $alertSuccess,
            "products" => $products
        )
    );
    http_response_code(200);
} else {
    header("HTTP/1.1 400 $alertError");
}