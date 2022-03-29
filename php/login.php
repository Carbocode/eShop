<?php
session_start();

if(isset($_POST["username"])){
    $username = $_POST["username"];
    $password = $_POST["password"];
}


if(!empty($username) && !empty($password)){
    $pdo = new PDO("mysql:host=localhost;","root","mysql");
    $dbName = "DefaultCube";
    $verifica= $pdo->query("use $dbName");
    $stmt=$pdo->query("SELECT * FROM account WHERE username='$username' AND pass='$password'");
    if($stmt->rowCount() > 0){
        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
            $_SESSION['nome']=$username;
            echo "benvenuto ".$_SESSION['nome'];       
        }
        $date = date("d/m/Y H:i:s");
        setcookie("ultimavisita", $date,  time() + (86400 * 30), "/");
    }
    else{
        echo "Accesso fallito";
    }
    $pdo=null;
}
?>