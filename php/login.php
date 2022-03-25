<?php
if(isset($_SESSION["nome"])){
    unset($_SESSION["nome"]); 
    header("Refresh:0");
}

if (isset($_POST["Signin"])){
    $pdo = new PDO("mysql:host=localhost;","root","mysql");
    $dbName = "DefaultCube";
    $verifica= $pdo->query("use $dbName");
    
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $stmt=$pdo->query("SELECT * FROM account WHERE username='$username' AND pass='$password'");
    if($stmt->rowCount() > 0){
        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
            $_SESSION['nome']=$username;
            print "<script>alert('benvenuto $username'); window.location.href ='../index.php';</script>";        
        }
        $date = date("d/m/Y H:i:s");
        setcookie("ultimavisita", $date,  time() + (86400 * 30), "/");
    }
    else{
        print "<script>alert('Account insistente');</script>";
    }
    $pdo=null;
}


?>