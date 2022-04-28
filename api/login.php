<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/api/config/database.php';
require $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php";

use \Firebase\JWT\JWT;

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


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
            $secret_key = "VkYp3s6v9y/B?E(H+MbQeThWmZq4t7w!";

            $randomString = generateRandomString(20);
            setcookie("ident", $randomString, [
                'expires' => time() + 86400,
                'path' => '/',
                'domain' => 'localhost',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict',
            ]);

            $serverName = "defaultcube.com"; // this can be the servername
            $issuedAt = time(); // issued at
            $notBefore = $issuedAt + 10; //not before in seconds
            $expire = $issuedAt + 86400; // expire time in seconds
            $token = array(
                "iss" => $serverName,
                "iat" => $issuedAt,
                "nbf" => $notBefore,
                "exp" => $expire,
                "username" => $username,
                "name" => $name,
                "surname" => $surname,
                "email" => $email,
                "tipo" => $tipo,
                "ident" => md5($randomString)
            );

            $jwt = JWT::encode($token, $secret_key, "HS256");
            $jwt = "Bearer " . $jwt;
            $alert = $alert . "Entrato con successo";
        } else {
            $alert = $alert . "Password sbagliata";
        }
    } else {
        $alert = $alert .  "Utente inesistente";
    }
} else {
    $alert = $alert .  "Riempi tutti i campi";
}

echo json_encode(
    array(
        "alert" => $alert,
        "jwt" => $jwt,
        "expireAt" => $expire
    )
);

$pdo = null;