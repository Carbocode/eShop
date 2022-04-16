<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/api/config/database.php';
require $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php";

use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$alert = "";
$jwt = "";
$expire = 0;

$data = json_decode(file_get_contents("php://input"));

$databaseService = new DatabaseService();
$pdo = $databaseService->getConnection();

if (trim(isset($data->username))) {
    $username = trim($data->username);
}

if (trim(isset($data->password))) {
    $password = md5(trim($data->password));
}

if (!empty($username) && !empty($password)) {
    $stmt = $pdo->query("SELECT * FROM account WHERE username='$username'");

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $username = $row["username"];
        $name = $row["nome"];
        $surname = $row["surname"];
        $email = $row["email"];
        $password2 = $row["pass"];
        $tipo = $row["tipo"];

        if ($password == $password2) {
            $secret_key = "s22wyX!!iYT@rQ#WT#5wbSb95R@^WD$3BJZdy8imxB4GRk3NYFP3H7YQbtnX*Mktb^72CTrq!JxQUqYG%3GJor8XFVyuaczMCb7nA2M&hh7zpb76%te!Xzs9@RrEDE^4";

            $serverName = "defaultcube.com"; // this can be the servername
            $issuedAt = time(); // issued at
            $notBefore = $issuedAt + 10; //not before in seconds
            $expire = $issuedAt + 60; // expire time in seconds
            $token = array(
                "iss" => $serverName,
                "iat" => $issuedAt,
                "nbf" => $notBefore,
                "exp" => $expire,
                "username" => $username,
                "name" => $name,
                "surname" => $surname,
                "email" => $email,
                "tipo" => $tipo
            );

            $jwt = JWT::encode($token, $secret_key, "HS256");
            $alert = $alert . "Successful login.";
        } else {
            $alert = $alert . "Password errata";
        }
    } else {
        $alert = $alert .  "Utente non esistente";
    }
} else {
    $alert = $alert .  "riempire tutti i campi";
}

echo json_encode(
    array(
        "alert" => $alert,
        "jwt" => $jwt,
        "expireAt" => $expire
    )
);

$pdo = null;