<?php
include_once '../api/config/database.php';
include '../api/config/auth.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$databaseService = new DatabaseService();
$pdo = $databaseService->getConnection();

$message = "";
$alert = "";

$headers = apache_request_headers();

$data = json_decode(file_get_contents("php://input"));

if ($headers["Authorization"] !== "null") {
    $token = $headers["Authorization"];
    $auth = new Authentication($token, $_COOKIE["ident"]);
    if (!($auth->isAdmin())) {
        header("Location: /");
        die();
    }
} else {
    header("Location: /");
    die();
}

if (isset($data->what)) {
    switch ($data->what) {
        case "read":
            $message = $message . showTable($pdo);
            break;
        case "delete":
            $alert = $alert . delete($pdo, $data->account);
            $message = $message . showTable($pdo);
            break;
        case "update":
            $alert = $alert . update($pdo, $data->account);
            $message = $message . showTable($pdo);
            break;
    }
}

function showTable($pdo)
{
    $message = "";
    $message = $message .
        "<tr>
        <th>
        <div class='screen-header-left'>
            <div class='screen-header-button close'></div>
            <div class='screen-header-button maximize'></div>
            <div class='screen-header-button minimize'></div>
        </div>
        </th>
        <th>Username</th>
        <th>Email</th>
        <th>Password</th>
        <th>Name</th>
        <th>Surname</th>
        <th>Type</th>
        <th>Delete</th>
        <th>Upgrade</th>
    </tr>";
    $query = "SELECT * FROM account";
    $stmt = $pdo->query($query);
    $i = 0;
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $i++;
        $message = $message .
            "<tr class='item'>
                <td>$i</td><td>" . $row["username"] . "</td> 
                <td>" . $row["email"] . "</td> 
                <td>" . $row["pass"] . "</td> 
                <td>" . $row["nome"] . "</td> 
                <td>" . $row["surname"] . "</td> 
                <td>" . $row["tipo"] . "</td>
                <td><input type='submit' name='Delete' value='Delete' onclick='crud(\"delete\", \"" . $row["username"] . "\")'/></td>
                <td><input type='submit' name='Upgrade' value='Upgrade' onclick='crud(\"update\", \"" . $row["username"] . "\")'/></td>
            </tr>";
    }
    return $message;
}

function delete($pdo, $user)
{
    $pdo->query("DELETE FROM account WHERE username='$user'");
    return " $user è stato appena eliminato";
}

function update($pdo, $user)
{
    $pdo->query("UPDATE account SET tipo='admin' WHERE username='$user'");
    return "$user è stato appena upgradato";
}

echo json_encode(
    array("message" => $message, "alert" => $alert)
);
header("HTTP/1.1 200 OK");

$pdo = null;