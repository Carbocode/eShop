<?php  
if (isset($_POST["Show"])){
    $pdo = new PDO("mysql:host=localhost;","root","mysql");
    $dbName = "DefaultCube";
    $verifica= $pdo->query("use $dbName");

    $query = "SELECT * FROM account";
    $stmt= $pdo -> query($query);

    foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
        print "Account: ".$row["username"]." ".$row["email"]." ".$row["pass"]." ".$row["nome"]." ".$row["surname"]." ".$row["tipo"]."<br>";
    }
    $pdo=null;
}
?>