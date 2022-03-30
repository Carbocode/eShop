<?php
$pdo = new PDO("mysql:host=localhost;","root","mysql");
$dbName = "DefaultCube";
$verifica= $pdo->query("use $dbName");
session_start(); 
if(isset($_SESSION["nome"])){ 
    echo "<li class='navbar-hover'><a>Profile</a></li>"."<li class='navbar-hover'><a>Orders</a></li>"."<li class='navbar-hover'><a>Settings</a></li>"."<br><li class='navbar-hover';'><a onclick='logout(event)'>Log-Out</a></li><br>"; 
}else{ 
    echo "<li class='navbar-hover'><a href='http://localhost/pages/signin.html'>Log-In</a></li class='navbar-hover'>"."<li class='navbar-hover'><a href='http://localhost/pages/signup.html'>Register</a></li>"; 
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
                echo "<li class='navbar-hover'><a href='../pages/addProduct.html'>Sell</a></li>"."<li class='navbar-hover'><a href='../pages/table.html'>Users</a></li>"; 
            } 
        } 
        $date = date("d/m/Y H:i:s"); 
        setcookie("ultimavisita",$date, time() + (86400 * 30), "/"); 
    } 
} 
$pdo=null; 
?>