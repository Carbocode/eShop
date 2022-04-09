<?php
include_once './config/database.php';
require "../vendor/autoload.php";

use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$settings = "";
$alert = "";

$databaseService = new DatabaseService();
$pdo = $databaseService->getConnection();

// $data = json_decode(file_get_contents("php://input"));
// $secret_key = "KenIPutMyBallzInYourJaw";
// $decoded = JWT::decode($data->jwt, $secret_key, array('HS256'));
// $alert = $alert . $decoded;




if (isset($_SESSION["nome"])) {
    $settings = $settings .
        "<li class='navbar-hover'><a>Profile</a></li>" .
        "<li class='navbar-hover'><a>Orders</a></li>" .
        "<li class='navbar-hover'><a>Settings</a></li>" .
        "<br><li class='navbar-hover';'><a id='logout'>Log-Out</a></li><br>";

    $nome = $_SESSION["nome"];
    $stmt = $pdo->query("SELECT tipo FROM account WHERE username='$nome'");
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll(PDO::FETCH_COLUMN) as $row) {
            if ($row == 'admin') {
                $settings = $settings .
                    "<li class='navbar-hover'><a href='http://localhost/pages/addProduct'>Sell</a></li>" .
                    "<li class='navbar-hover'><a href='http://localhost/pages/table'>Users</a></li>";
            }
        }
    }
} else {
    $settings = $settings .
        "<li class='navbar-hover'><a href='http://localhost/pages/signin'>Log-In</a></li>" .
        "<li class='navbar-hover'><a href='http://localhost/pages/signup'>Register</a></li>";
}

echo json_encode(
    array("settings" => $settings, "alert" => $alert)
);

if (isset($data->logout)) {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
}
$pdo = null;