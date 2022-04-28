<?php
include $_SERVER['DOCUMENT_ROOT'] . '/api/config/database.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/config/auth.php';
$currentDir = "../";

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$message = "";
$alert = "";

$headers = apache_request_headers();

$databaseService = new DatabaseService();
$pdo = $databaseService->getConnection();

$data = json_decode(file_get_contents("php://input"));

$cart = (array)$data->products;

foreach ($cart as $x) {

    $stmt = $pdo->query("select * from products where id_prod='$x'");
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $message = $message .
                "<tr class='item'>
                <td>  <img src='" . $currentDir . $row["img"] . "'  width='150' height='100'> </td>
                <td>" . $row["nome"] . "</td> 
                <td>" . $row["prezzo"] . "$</td>
                <td><input type='submit' value='Elimina' onclick='removeCart(event, " . $row["id_prod"] . ")'/></td>
            </tr>";
        }
    }
}

echo json_encode(
    array(
        "alert" => $alert,
        "message" => $message
    )
);