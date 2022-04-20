<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/api/config/database.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$settings = "";
$alert = "";

$databaseService = new DatabaseService();
$pdo = $databaseService->getConnection();

$uploadOk = TRUE;
if (isset($_FILES["file"]["tmp_name"])) {

    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
    } else {
        $alert = $alert . "File is not an image.";
        $uploadOk = FALSE;
    }

    // Check file size
    if ($_FILES["file"]["size"] > 2000000) {
        $alert = $alert . "Sorry, your file is too large.";
        $uploadOk = FALSE;
    }

    // Allow certain file formats
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $alert = $alert . "Sorry, only JPG, JPEG, PNG files are allowed.";
        $uploadOk = FALSE;
    }
    if ($uploadOk) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $currentDir . $target_file)) {
            $target_file = $target_dir . $idProd . basename($_FILES["file"]["name"]);
            $query = "UPDATE products SET img='$target_dir' WHERE id_prod='" . $_POST['id'] . "'";
            $pdo->query($query);
        } else {
            $alert = $alert . "Sorry, there was an error uploading your file, you can always do it later";
        }
    }
}

echo json_encode(
    array("settings" => $settings, "alert" => $alert)
);
$pdo = null;