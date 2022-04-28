<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/api/config/database.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$settings = "";
$alert = "";

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

    $alert = $alert . "Prodotto aggiunto\n";
} else {
    $alert = $alert . "Riempi tutti i campi\n";
}

echo json_encode(
    array("settings" => $settings, "alert" => $alert, "id" => $idProd)
);
$pdo = null;