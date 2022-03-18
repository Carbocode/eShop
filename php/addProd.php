<?php
$pdo = new PDO("mysql:host=localhost;","root","mysql");
$dbName = "DefaultCube";
$currentDir = "../";
$verifica= $pdo->query("use $dbName");

if(isset($_POST["submitProd"])) {
    $target_dir = "userImg/products/";
    $target_file = $target_dir.basename($_FILES["images"]["name"]);
    $uploadOk = 1;

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["images"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["images"]["size"] > 2000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
  
    // Allow certain file formats
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Sorry, only JPG, JPEG, PNG files are allowed.";
        $uploadOk = 0;
    }

    $name = $_POST['name'];
    $price = $_POST['price'];
    $idProd = 0;

    $stmt=$pdo->query("SELECT * FROM products order by id_prod desc limit 1");
    if($stmt->rowCount() > 0){
        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
            $idProd = 1 + $row['id_prod'];       
        }
    }
    
    $query = "INSERT INTO products(id_prod, nome, prezzo, img) value($idProd, '$name', $price, '$target_file')";
    $pdo -> query($query);

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["images"]["tmp_name"], $currentDir.$target_file)) {
        //echo "The file ". htmlspecialchars( basename( $_FILES["images"]["name"])). " has been uploaded.";
        } else {
        //echo "Sorry, there was an error uploading your file.";
        }
    }
}

$pdo = null;
?>