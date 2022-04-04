<?php
$pdo = new PDO("mysql:host=localhost;","root","mysql");
$dbName = "DefaultCube";
$verifica= $pdo->query("use $dbName");
session_start();

if(!empty($_POST["username"]) && !empty($_POST["password"])){
    $username=$_POST["username"];
    $password=$_POST["password"];
    $stmt=$pdo->query("SELECT * FROM account WHERE username='$username' AND pass='$password'");
    if($stmt->rowCount() > 0){
        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
            $_SESSION['nome']=$username;
            echo "Benvenuto ".$_SESSION['nome'];       
        }
    }
    else{
        echo "Utente non esistente";
    }
}

$pdo=null;
?>