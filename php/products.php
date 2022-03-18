<?php
$pdo = new PDO("mysql:host=localhost;","root","mysql");
$dbName = "DefaultCube";
$currentDir = "../";
$pdo->query("use $dbName");

$addProduct="INSERT INTO products value(1,'Cazzone',20,'C:/Desktop/img.png')";

$query = "SELECT * FROM products";
$stmt= $pdo -> query($query);
if($stmt->rowCount() > 0){
    foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
        echo "<div class='card'><div class='card-image' style='background-image: url(".$currentDir.$row['img'].");'></div><div class='card-text'><h1>".$row['nome']."</h1><p>".$row['prezzo']."$</p><form method='POST'><input type='submit' name='Buy' value='Add to Cart' class='card-buy' /></form></div></div>";
    }
}

if(isset($_POST['Buy'])){
    echo "<script>alert('Hai comprato');</script>";
}
?>