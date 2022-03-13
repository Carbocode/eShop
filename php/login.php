<?php
if (isset($_POST["Signin"])){
    $pdo = new PDO("mysql:host=localhost;","root","mysql");
    $dbName = "DefaultCube";
    $verifica= $pdo->query("use $dbName");
    
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $stmt=$pdo->query("SELECT * FROM account WHERE username='$username' AND pass='$password'");
    if($stmt->rowCount() > 0){
        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
            print "<script>alert('benvenuto'); window.location.href ='../index.php';</script>";        
        }
        $date = date("d/m/Y H:i:s");
        setcookie("ultimavisita", $date,  time() + (86400 * 30), "/");
    }
    else{
        print "<script>alert('ciccia');</script>";
    }
    $pdo=null;
}


?>