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

$items = json_decode($data->who);

if (isset($data->what)) {
    switch ($data->what) {
        case "read":
            $message = $message . showTable($pdo, $data->where);
            break;
        case "delete":
            $alert = $alert . delete($pdo, $data->where, $items);
            $message = $message . showTable($pdo, $data->where);
            break;
        case "update":
            $alert = $alert . update($pdo, $data->where, $items);
            $message = $message . showTable($pdo, $data->where);
            break;
    }
}

function showTable($pdo, $table)
{
    $message = "";
    $tableNames = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
    if (!in_array($table, $tableNames, true)) {
        throw new UnexpectedValueException('Unknown table name provided!');
    }
    $stmt = $pdo->query('SELECT * FROM ' . $table);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $columnCount = $stmt->columnCount();

    $message = $message . '<table id="tableElement" data-table-name="' . $table . '">';
    // Display table header
    $message = $message . '<thead>';
    $message = $message . '<th></th>';

    for ($i = 0; $i < $columnCount; $i++) {
        $message = $message . '<th>' . htmlspecialchars($stmt->getColumnMeta($i)['name']) . '</th>';
    }
    $message = $message . '</thead>';
    // If there is data then display each row
    if ($data) {
        $i = 0;
        $message = $message . '<tbody>';
        foreach ($data as $row) {
            $i++;
            $message = $message . '<tr>';
            $message = $message . "<td><input type='checkbox' id='table' data-id='$i'/></td>";

            foreach ($row as $cell) {
                $message = $message . '<td>' . htmlspecialchars($cell) . '</td>';
            }
            $message = $message . '</tr>';
        }
        $message = $message . '</tbody>';
    } else {
        $message = $message . '<tr><td colspan="' . $columnCount . '">No records in the table!</td></tr>';
    }
    $message = $message . '</table>';
    return $message;
}

function delete($pdo, $table, $items)
{
    foreach ($items as $id) {
        $pdo->query("DELETE FROM $table WHERE id='$id'");
    }
    return "$items è stato appena eliminato";
}

function update($pdo, $table, $items)
{
    foreach ($items as $id) {
        $pdo->query("UPDATE $table SET tipo='admin' WHERE username='$id'");
    }

    return "$items è stato appena upgradato";
}

echo json_encode(
    array("message" => $message, "alert" => $alert)
);
header("HTTP/1.1 200 OK");

$pdo = null;