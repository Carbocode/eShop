<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/api/config/database.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$currentDir = "../";
$target_dir = "userImg/products/";

$settings = "";
$alert = $_POST['alert'];

$databaseService = new DatabaseService();
$pdo = $databaseService->getConnection();

$uploadOk = TRUE;
if (isset($_FILES["file"]["tmp_name"])) {

    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
    } else {
        $alert = $alert . "Il file non è un'immagine\n";
        $uploadOk = FALSE;
    }

    // Check file size
    if ($_FILES["file"]["size"] > 2000000) {
        $alert = $alert . "Il file è troppo largo\n";
        $uploadOk = FALSE;
    }

    // Allow certain file formats
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $alert = $alert . "Accettati solo JPG, JPEG, PNG\n";
        $uploadOk = FALSE;
    }
    if ($uploadOk) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $currentDir . $target_file)) {
            $target_file = $target_dir . $idProd . basename($_FILES["file"]["name"]);
            $query = "UPDATE products SET img='$target_file' WHERE id_prod='" . $_POST['id'] . "'";
            $pdo->query($query);
        } else {
            $alert = $alert . "C'è stato un errore durante il caricamento dell'immagine. Puoi sempre aggiungerla in seguito\n";
            $query = "UPDATE products SET img='userImg/products/16.jpg' WHERE id_prod='" . $_POST['id'] . "'";
            $pdo->query($query);
        }
    }
}

echo json_encode(
    array("settings" => $settings, "alert" => $alert)
);
$pdo = null;