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
                        <li><a href="signin.php">Log-In</a></li>
                        <li><a>Log-Out</a></li>
                        <li><a href="signup.php">Register</a></li>
                        <li><a href="addProduct.php">Sell</a></li>
                        <li><a>Profile</a></li>
                        <li><a>Settings</a></li>
                        <li><a>Orders</a></li>
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
                <a href="cart.php"><img src="../img/shopping-cart.png" /></a>
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