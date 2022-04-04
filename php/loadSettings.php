<?php
$pdo = new PDO("mysql:host=localhost;","root","mysql");
$dbName = "DefaultCube";
$verifica= $pdo->query("use $dbName");
session_start();

if(isset($_SESSION["nome"])){ 
    echo 
    "<li class='navbar-hover'><a>Profile</a></li>".
    "<li class='navbar-hover'><a>Orders</a></li>".
    "<li class='navbar-hover'><a>Settings</a></li>".
    "<br><li class='navbar-hover';'><a onclick='logout(event)'>Log-Out</a></li><br>";
     
    $nome=$_SESSION["nome"]; 
    $stmt=$pdo->query("SELECT tipo FROM account WHERE username='$nome'"); 
    if($stmt->rowCount() > 0){
        foreach($stmt->fetchAll(PDO::FETCH_COLUMN) as $row){
            if($row=='admin'){ 
                echo 
                "<li class='navbar-hover'><a href='http://localhost/pages/addProduct'>Sell</a></li>".
                "<li class='navbar-hover'><a href='http://localhost/pages/table'>Users</a></li>"; 
            } 
        }
    } 
}else{ 
    echo 
    "<li class='navbar-hover'><a href='http://localhost/pages/signin'>Log-In</a></li>".
    "<li class='navbar-hover'><a href='http://localhost/pages/signup'>Register</a></li>"; 
} 

if(isset($_POST["Logout"])){ 
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
} 
$pdo=null; 
?>