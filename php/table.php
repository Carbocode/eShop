<?php  
session_start();
$pdo = new PDO("mysql:host=localhost;","root","mysql");
$dbName = "DefaultCube";
$verifica= $pdo->query("use $dbName");

if(isset($_POST["table"])){
    echo 
    "<tr>
        <th>
        <div class='screen-header-left'>
            <div class='screen-header-button close'></div>
            <div class='screen-header-button maximize'></div>
            <div class='screen-header-button minimize'></div>
        </div>
        </th>
        <th>Username</th>
        <th>Email</th>
        <th>Password</th>
        <th>Name</th>
        <th>Surname</th>
        <th>Type</th>
        <th>Delete</th>
        <th>Upgrade</th>
    </tr>";
    $query = "SELECT * FROM account";
    $stmt= $pdo -> query($query);
    $i=0;
    foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
        $i++;
        echo 
        "<tr class='item'>
            <td>$i</td><td>".$row["username"]."</td> 
            <td>".$row["email"]."</td> 
            <td>".$row["pass"]."</td> 
            <td>".$row["nome"]."</td> 
            <td>".$row["surname"]."</td> 
            <td>".$row["tipo"]."</td>
            <td><input type='submit' name='Delete' value='Delete' onclick='erease(event,\"".$row["username"]."\")'/></td>
            <td><input type='submit' name='Upgrade' value='Upgrade' onclick='upgrade(event,\"".$row["username"]."\")'/></td>
        </tr>";
    }
}

if(isset($_POST["usernameD"])){
    $userToDelete=$_POST["usernameD"];
    $pdo -> query("DELETE FROM account WHERE username='$userToDelete'");
    echo "Utente $userToDelete eliminato";
}

if(isset($_POST["usernameU"])){
    $userToUpgrade=$_POST["usernameU"];
    $pdo -> query("UPDATE account SET tipo='admin' WHERE username='$userToUpgrade'");
    echo "Utente $userToUpgrade è divenuto admin";
}

$pdo=null;
?>