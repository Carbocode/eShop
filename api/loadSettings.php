<?php
include $_SERVER['DOCUMENT_ROOT'] . '/api/config/database.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/config/auth.php';

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
    $alert = $alert . "successfully logged out";
}

if ($headers["Authorization"] !== "null") {
    $token = $headers["Authorization"];
    $auth = new Authentication($token, $_COOKIE["ident"]);
    if ($auth->isLogged()) {
        $settings = $settings .
            "<li class='navbar-hover'><a>Profile</a></li>" .
            "<li class='navbar-hover'><a>Orders</a></li>" .
            "<li class='navbar-hover'><a>Settings</a></li>" .
            "<br><li class='navbar-hover' onClick='logout(event)'><a id='logout'>Log-Out</a></li><br>";

        if ($auth->isAdmin()) {
            /*$stmt = $pdo->query("SELECT tipo FROM account WHERE username='$nome'");
        if ($stmt->rowCount() > 0) {
            foreach ($stmt->fetchAll(PDO::FETCH_COLUMN) as $row) {
                if ($row == 'admin') {*/
            $settings = $settings .
                "<li class='navbar-hover'><a href='/pages/addProduct'>Sell</a></li>" .
                "<li class='navbar-hover'><a href='/pages/table'>Control Panel</a></li>";
            /*}
            }
        }*/
        }
    }
}

if (empty($settings)) {
    $settings = $settings .
        "<li class='navbar-hover'><a href='/pages/signin'>Log-In</a></li>" .
        "<li class='navbar-hover'><a href='/pages/signup'>Register</a></li>";
}

echo json_encode(
    array("settings" => $settings, "alert" => $alert)
);
$pdo = null;