<?php  

$pdo = new PDO("mysql:host=localhost;","root","mysql");
$dbName = "DefaultCube";
$verifica= $pdo->query("use $dbName");

$query = "SELECT * FROM account";
$stmt= $pdo -> query($query);

foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
    print "<tr><form method='POST'><td><input name='Username' value='".$row["username"]."' /></td> <td>".$row["email"]."</td> <td>".$row["pass"]."</td> <td>".$row["nome"]."</td> <td>".$row["surname"]."</td> <td>".$row["tipo"]."</td><td><input type='submit' name='Delete' value='Delete'/></td><td><input type='submit' name='Upgrade' value='Upgrade'/></td></form></tr>";
}

if(isset($_POST["Delete"])){
    $userToDelete=$_POST["Username"];
    $pdo -> query("DELETE FROM account WHERE username='$userToDelete'");
}

if(isset($_POST["Upgrade"])){
    $userToUpgrade=$_POST["Username"];
    $pdo -> query("UPDATE account SET tipo='admin' WHERE username='$userToUpgrade'");
}
$pdo=null;
?>