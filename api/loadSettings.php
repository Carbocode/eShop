<?php
include $_SERVER['DOCUMENT_ROOT'] . '/api/config/database.php';
require $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php";

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

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

if (isset($data->logout)) {
    //nothing to do
    $alert = $alert . "successfully logged out";
}

$headers = apache_request_headers();
if (isset($headers["Authorization"]) & !empty($headers["Aturhorization"])) {
    $token = $headers["Authorization"];
    try {
        $secret_key = "s22wyX!!iYT@rQ#WT#5wbSb95R@^WD$3BJZdy8imxB4GRk3NYFP3H7YQbtnX*Mktb^72CTrq!JxQUqYG%3GJor8XFVyuaczMCb7nA2M&hh7zpb76%te!Xzs9@RrEDE^4";
        $token = JWT::decode($token, new Key($secret_key, 'HS256'));
    } catch (\Exception $e) {
        echo $e;
    }
    if (isset($token->username)) {
        $settings = $settings .
            "<li class='navbar-hover'><a>Profile</a></li>" .
            "<li class='navbar-hover'><a>Orders</a></li>" .
            "<li class='navbar-hover'><a>Settings</a></li>" .
            "<br><li class='navbar-hover' onClick='logout(event)'><a id='logout'>Log-Out</a></li><br>";

        $nome = $token->username;
        if (isset($token->tipo)) {
            $stmt = $pdo->query("SELECT tipo FROM account WHERE username='$nome'");
            if ($stmt->rowCount() > 0) {
                foreach ($stmt->fetchAll(PDO::FETCH_COLUMN) as $row) {
                    if ($row == 'admin') {
                        $settings = $settings .
                            "<li class='navbar-hover'><a href='/pages/addProduct'>Sell</a></li>" .
                            "<li class='navbar-hover'><a href='/pages/table'>Users</a></li>";
                    }
                }
            }
        }
    }
} else {
    $settings = $settings .
        "<li class='navbar-hover'><a href='/pages/signin'>Log-In</a></li>" .
        "<li class='navbar-hover'><a href='/pages/signup'>Register</a></li>";
}

echo json_encode(
    array("settings" => $settings, "alert" => $alert)
);
$pdo = null;