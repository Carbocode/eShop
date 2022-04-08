<?php
$pdo = new PDO("mysql:host=localhost;", "root", "mysql");
$dbName = "DefaultCube";
$verifica = $pdo->query("use $dbName");
session_start();
$currentDir = "../";
$target_dir = "userImg/products/";

if (trim(isset($_POST["name"]))) {
    $name = $_POST["name"];
    echo $name;
}

if (trim(isset($_POST["price"]))) {
    $price = trim($_POST["price"]);
    echo $price;
}

if (trim(isset($_POST["description"]))) {
    $description = $_POST["description"];
    echo $description;
}

$uploadOk = TRUE;
if (isset($_FILES["file"]["tmp_name"])) {

    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
    } else {
        echo "File is not an image.";
        $uploadOk = FALSE;
    }

    // Check file size
    if ($_FILES["file"]["size"] > 2000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = FALSE;
    }

    // Allow certain file formats
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Sorry, only JPG, JPEG, PNG files are allowed.";
        $uploadOk = FALSE;
    }
}

if (!empty($name) && !empty($price) && !empty($description) && $uploadOk) {
    $idProd = 0;

    $stmt = $pdo->query("SELECT * FROM products order by id_prod desc limit 1");
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $idProd = 1 + $row['id_prod'];
        }
    }

    $target_file = $target_dir . $idProd . basename($_FILES["file"]["name"]);
    $query = "INSERT INTO products(id_prod, nome, prezzo, img, descr) value($idProd, '$name', $price, '$target_file', '$description')";
    $pdo->query($query);

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $currentDir . $target_file)) {
    } else {
        echo "Sorry, there was an error uploading your file, you can always do it later";
    }
} else {
    echo "riempire prima tutti i campi";
}

$pdo = null;