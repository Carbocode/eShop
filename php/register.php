<?php
$pdo = new PDO("mysql:host=localhost;","root","mysql");
$dbName = "DefaultCube";
$verifica= $pdo->query("use $dbName");

if (!empty(trim($_POST["name"])) && !empty(trim($_POST["surname"])) && !empty(trim($_POST["username"])) && !empty(trim($_POST["email"])) && !empty(trim($_POST["password"]))){
    $name = trim($_POST["name"]);
    $surname = trim($_POST["surname"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $uniqueUsername=TRUE;
    $validEmail=TRUE;
    $uniqueEmail=TRUE; 
    $validUsername=TRUE;
    $validName=TRUE;
    $validSurname=TRUE;
    
    if($stmt=$pdo->query("SELECT * FROM account WHERE username='$username'")){
        if($stmt -> rowCount()>0){
            $uniqueUsername= FALSE;
            print "Questo username è già in uso \n";
        }
    }

    if(!preg_match('/^[a-zA-Z]+$/', $name)){
        print "Il nome può contenere solo lettere \n";
        $validName=FALSE;
    }
    if(!preg_match('/^[a-zA-Z]+$/', $surname)){
        print "Il cognome può contenere solo lettere \n";
        $validSurname=FALSE;
    }

    if(!preg_match('/^[a-zA-Z0-9_]+$/', $username)){
        print "L'username può contenere solo lettere, numeri e underscore \n";
        $validUsername=FALSE;
    }

    if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email)){
        $validEmail=FALSE;
        print "Inserire una mail valida \n";
    }
        

    if ($stmt=$pdo->query("SELECT * FROM account WHERE email='$email'"))
    {
        if($stmt -> rowCount()>0){
            $uniqueEmail=FALSE;
            print "Questa mail è già in uso \n";
        }

    }
        

    if($uniqueUsername && $validEmail && $uniqueEmail && $validName && $validSurname && $validUsername){
        $sqlInsert = "INSERT INTO account(username, nome, surname, email, pass, tipo) value('$username', '$name', '$surname', '$email', '$password', 'normale')";
        $pdo->query($sqlInsert);
        echo "Registrato con Successo";
    }
}
?>