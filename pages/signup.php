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
                        <li><a href="pages/addProduct.php">Sell</a></li>
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

    <br>

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
                    <div class="app-title">SIGN UP</div>
                </div>
                <div class="screen-body-item">
                    <form class="app-form" method="POST">
                        <div class="app-form-group">
                            <input name="name" class="app-form-control" placeholder="Name" />
                        </div>
                        <div class="app-form-group">
                            <input name="surname" class="app-form-control" placeholder="Surname" />
                        </div>
                        <div class="app-form-group message">
                            <input name="username" class="app-form-control" placeholder="Username" />
                        </div>
                        <div class="app-form-group">
                            <input type="email" name="email" class="app-form-control" placeholder="E-Mail" />
                        </div>
                        <div class="app-form-group message">
                            <input type="password" name="password" class="app-form-control" placeholder="Password" />
                        </div>
                        <div class="app-form-group buttons">
                            <input type="submit" name="Signup" class="app-form-button" value="Sign-Up" />
                        </div>
                        <?php require '../php/register.php'; ?>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <div>
        <form method="POST">
            <input type="submit" name="Show" value="Show Table" style="border-radius:10px;">
        </form>
        <?php require '../php/table.php'; ?>
    </div>

</body>

</html>