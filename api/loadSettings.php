<?php
include '../api/config/database.php';
include '../api/config/auth.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$settings = "";
$alert = "";

$headers = apache_request_headers();

$databaseService = new DatabaseService();
$pdo = $databaseService->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (isset($data->logout)) {
    setcookie('cart', '', time() - 7000000, '/');
    setcookie('ident', '', time() - 7000000, '/');
    $alert = $alert . "successfully logged out";
}

if ($headers["Authorization"] !== "null") {
    $token = $headers["Authorization"];
    $auth = new Authentication($token, $_COOKIE["ident"]);
    if ($auth->isLogged()) {
        $settings = $settings .
            "<li class='navbar-hover'><a><i class='fa-solid fa-user'></i>Profilo</a></li>" .
            "<li class='navbar-hover'><a><i class='fa-solid fa-truck-fast'></i>Ordini</a></li>" .
            "<li class='navbar-hover'><a><i class='fa-solid fa-gear'></i>Impostazioni</a></li>" .
            "<br><li class='navbar-hover' onClick='logout(event)'><a id='logout'><i class='fa-solid fa-right-from-bracket'></i>Esci</a></li><br>";

        if ($auth->isAdmin()) {
            /*$stmt = $pdo->query("SELECT tipo FROM account WHERE username='$nome'");
        if ($stmt->rowCount() > 0) {
            foreach ($stmt->fetchAll(PDO::FETCH_COLUMN) as $row) {
                if ($row == 'admin') {*/
            $settings = $settings .
                "<li class='navbar-hover'><a href='/pages/addProduct'><i class='fa-solid fa-sack-dollar'></i>Vendi</a></li>" .
                "<li class='navbar-hover'><a href='/pages/admin'><i class='fa-solid fa-screwdriver-wrench'></i>Pannello di Controllo</a></li>";
            /*}
            }
        }*/
        }
    }
}

if (empty($settings)) {
    $settings = $settings .
        "<li class='navbar-hover'><a onclick='loadLogin(event)'><i class='fa-solid fa-right-to-bracket'></i>Log-In</a></li>" .
        "<li class='navbar-hover'><a onclick='loadRegister(event)'><i class='fa-solid fa-address-card'></i>Registrati</a></li>";
}

echo json_encode(
    array("settings" => $settings, "alert" => $alert)
);
header("HTTP/1.1 200 OK");
$pdo = null;