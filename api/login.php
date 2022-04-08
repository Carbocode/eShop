<?php
include_once './config/database.php';
require "../vendor/autoload.php";

use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

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
            $secret_key = "KenIPutMyBallzInYourJaw";

            $serverName = "defaultcube.com"; // this can be the servername
            $issuedAt = time(); // issued at
            $notBefore = $issuedAt + 10; //not before in seconds
            $expire = $issuedAt + 60; // expire time in seconds
            $token = array(
                "iss" => $serverName,
                "iat" => $issuedAt,
                "nbf" => $notBefore,
                "exp" => $expire,
                "data" => array(
                    "username" => $username,
                    "name" => $name,
                    "surname" => $surname,
                    "email" => $email,
                    "tipo" => $tipo
                )
            );

            http_response_code(200);

            $jwt = JWT::encode($token, $secret_key, "HS256");
            echo json_encode(
                array(
                    "message" => "Successful login.",
                    "jwt" => $jwt,
                    "expireAt" => $expire
                )
            );
        } else {

            http_response_code(401);
            echo json_encode(array("message" => "Password errata"));
        }
    } else {
        echo "Utente non esistente";
    }
} else {
    echo "riempire tutti i campi";
}

$pdo = null;