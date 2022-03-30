<?php
$pdo = new PDO("mysql:host=localhost;","root","mysql");
$dbName = "DefaultCube";
$verifica= $pdo->query("use $dbName");
session_start(); 
if(isset($_SESSION["nome"])){ 
    echo "<li><a onclick='logout(event)'>Log-Out</a></li>"."<li><a>Profile</a></li>"."<li><a>Settings</a></li>"."<li><a>Orders</a></li>"; 
}else{ 
    echo "<li><a href='http://localhost/pages/signin.html'>Log-In</a></li>"."<li><a href='http://localhost/pages/signup.html'>Register</a></li>"; 
} 

if(isset($_POST["Logout"])){ 
    unset($_SESSION["nome"]);
    header("Refresh:0"); 
} 

if(isset($_SESSION["nome"])){
    $nome=$_SESSION["nome"]; 
    $stmt=$pdo->query("SELECT * FROM account WHERE username='$nome'"); 
    if($stmt->rowCount() > 0){
        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
            if($row['tipo']=='admin'){ 
                echo "<li><a href='../pages/addProduct.html'>Sell</a></li>"."<li><a href='../pages/table.html'>Users</a></li>"; 
            } 
        } 
        $date = date("d/m/Y H:i:s"); 
        setcookie("ultimavisita",$date, time() + (86400 * 30), "/"); 
    } 
} 
$pdo=null; 
?>