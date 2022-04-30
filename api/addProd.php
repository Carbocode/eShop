<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/api/config/database.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/config/auth.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$headers = apache_request_headers();

$settings = "";
$alertError = "";
$alertSuccess = "";

$databaseService = new DatabaseService();
$pdo = $databaseService->getConnection();

$data = json_decode(file_get_contents("php://input"));

$currentDir = "../";
$target_dir = "userImg/products/";

if (trim(isset($data->name))) {
    $name = $data->name;
}

if (trim(isset($data->price))) {
    $price = trim($data->price);
}

if (trim(isset($data->description))) {
    $description = $data->description;
}

if (!empty($name) && !empty($price) && !empty($description)) {
    $idProd = 0;

    $stmt = $pdo->query("SELECT * FROM products order by id_prod desc limit 1");
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $idProd = 1 + $row['id_prod'];
        }
    }

    $query = "INSERT INTO products(id_prod, nome, prezzo, img, descr) value($idProd, '$name', $price, '', '$description')";
    $pdo->query($query);

    $alertSuccess = $alertSuccess . "Prodotto aggiunto\n";
} else {
    $alertError = $alertError . "Riempi tutti i campi\n";
}

if (empty(trim($alertError))) {
    echo json_encode(array("settings" => $settings, "alert" => $alertSuccess, "id" => $idProd));
    header("HTTP/1.1 200 OK");
} else {
    echo json_encode(array("alert" => $alertError));
    header("HTTP/1.1 400 OK");
}

$pdo = null;