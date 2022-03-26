<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Title</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/script.js"></script>
</head>

<body>

    <header>
        <div class="navbar">
            <div class="account">
                <div class="account-dropdown">
                    <ul>
                        <?php
                            $pdo = new PDO("mysql:host=localhost;","root","mysql");
                            $dbName = "DefaultCube";
                            $verifica= $pdo->query("use $dbName");
                            session_start();
                            if(isset($_SESSION["nome"])){
                                echo "<li><form method='POST'><input type='submit' name='Logout' value='Log-Out' /></form></li>";
                                echo "<li><a>Profile</a></li>";
                                echo "<li><a>Settings</a></li>";
                                echo "<li><a>Orders</a></li>";
                            }else{
                                echo "<li><a href='../pages/signin.php'>Log-In</a></li>";
                                echo "<li><a href='../pages/signup.php'>Register</a></li>";
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
                                            echo "<li><a href='../pages/addProduct.php'>Sell</a></li>";
                                            echo "<li><a href='../pages/table.php'>Users</a></li>";
                                        }
                                    }
                                    $date = date("d/m/Y H:i:s");
                                    setcookie("ultimavisita", $date,  time() + (86400 * 30), "/");
                                }
                            }
                            $pdo=null;
                        ?>
                    </ul>
                </div>
            </div>
            <div class="sections">
                <a href="../index.php">DefaultCube</a>
                <input id="burgermenu" type="checkbox" />
                <div class="burger">
                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3"></div>
                </div>
                <ul class="dropdown">
                    <li><a href="">Shop</a></li>
                    <li><a href="">Commission</a></li>
                    <li><a href="">News</a></li>
                </ul>
            </div>
            <div class="cart">
                <a class="cart-img" href="../pages/cart.php"></a>
            </div>
        </div>
    </header>
    <br><br><br><br><br><br><br>

    <section>
        <div class="screen">
            <div class="screen-header">
                <div class="screen-header-left">
                    <div class="screen-header-button close"></div>
                    <div class="screen-header-button maximize"></div>
                    <div class="screen-header-button minimize"></div>
                </div>
            </div>
            <div class="screen-body">
                <div class="screen-body-item left">
                    <div class="app-title">SELL</div>
                </div>
                <div class="screen-body-item">
                    <form class="app-form" method="POST" enctype="multipart/form-data">
                        <div class="app-form-group message">
                            <input type="file" name="images" class="app-form-control" accept="image/png, image/jpeg"
                                multiple>
                        </div>
                        <div class="app-form-group message">
                            <input name="name" placeholder="Nome" class="app-form-control" />
                        </div>
                        <div class="app-form-group buttons">
                            <input type="number" step="0.01" name="price" placeholder="Prezzo"
                                class="app-form-control" />
                        </div>
                        <div class="app-form-group buttons">
                            <input type="submit" name="submitProd" class="app-form-button" value="Add" />
                        </div>
                        <?php require '../php/addProd.php'; ?>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>