<?php
$pdo = new PDO("mysql:host=localhost;","root","mysql");
$dbName = "DefaultCube";
$verifica= $pdo->query("use $dbName");

if (isset($_POST["Signup"])){
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $uniqueUsername=TRUE;
    $validEmail=TRUE;
    $uniqueEmail=TRUE;
    
    /*if($pdo->query("SELECT * FROM account WHERE username='$username'")){
        $uniqueUsername= FALSE;
        print "<script>alert('Questo username è già in uso');>";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $validEmail=FALSE;

    if ($pdo->query("SELECT * FROM account WHERE email='$email'"))
    {
        $uniqueEmail=FALSE;
        print "<script>alert('Questa mail è già in uso');";

    }*/
        

    if($uniqueUsername && $validEmail && $uniqueEmail){
        $sqlInsert = "INSERT INTO account(username, nome, surname, email, pass) value('$username', '$name', '$surname', '$email', '$password')";
        $pdo->query($sqlInsert);
        echo "<script>alert('Registrato con Successo'); window.location.href ='../index.php';</script>";
    }
}
?>