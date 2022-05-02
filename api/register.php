<?php
include_once '../api/config/database.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$databaseService = new DatabaseService();
$pdo = $databaseService->getConnection();

$data = json_decode(file_get_contents("php://input"));

$validName = FALSE;
$validSurname = FALSE;
$validUsername = FALSE;
$validEmail = FALSE;
$validPassword = FALSE;

$alertError = "";
$alertSuccess = "";

if (trim(isset($data->name))) {
    $name = trim($data->name);

    if (preg_match('/^[a-zA-Z]+$/', $name)) {
        $validName = TRUE;
    } else {
        $alertError = $alertError . "Il nome puó contenere solo lettere \n";
    }
}

if (trim(isset($data->surname))) {
    $surname = trim($data->surname);

    if (preg_match('/^[a-zA-Z]+$/', $surname)) {
        $validSurname = TRUE;
    } else {
        $alertError = $alertError . "Il cognome puó contenere solo lettere \n";
    }
}

if (trim(isset($data->username))) {
    $username = trim($data->username);

    if (preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        if ($stmt = $pdo->query("SELECT * FROM account WHERE username='$username'")) {
            if ($stmt->rowCount() > 0) {
                $alertError = $alertError .  "Questo utente esiste già \n";
            } else {
                $validUsername = TRUE;
            }
        }
    } else {
        $alertError = $alertError .  "Lo Username puó solo contenere lettere, numeri o underscore \n";
    }
}

if (trim(isset($data->email))) {
    $email = trim($data->email);

    if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email)) {
        if ($stmt = $pdo->query("SELECT * FROM account WHERE email='$email'")) {
            if ($stmt->rowCount() > 0) {
                $alertError = $alertError .  "Questa email è gia in uso \n";
            } else {
                $validEmail = TRUE;
            }
        }
    } else {
        $alertError = $alertError .  "Inserire una mail valida \n";
    }
}

if (trim(isset($data->password))) {
    $password = trim($data->password);

    if (strlen($password) > 7) {
        if (preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $password)) {
            $validPassword = TRUE;
            $password_hash = md5($password);
        } else {
            $alertError = $alertError .  'La Passord non rispetta i requisiti di sicurezza';
        }
    } else {
        $alertError = $alertError .  'La Password è troppo corta';
    }
}

if ($validUsername && $validEmail && $validName && $validSurname && $validPassword) {
    $sqlInsert = "INSERT INTO account(username, nome, surname, email, pass, tipo) value('$username', '$name', '$surname', '$email', '$password_hash', 'normale')";
    $pdo->query($sqlInsert);
    $alertSuccess = $alertSuccess .  "Registrato con successo";
}

if (empty(trim($alertError))) {
    echo json_encode(array("alert" => $alertSuccess));
    header("HTTP/1.1 200 OK");
} else {
    header("HTTP/1.1 400 $alertError");
}