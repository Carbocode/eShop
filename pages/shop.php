<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>DefaultCube</title>
    <link rel="stylesheet" href="../css/style.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../js/script.js"></script>
</head>

<body>

    <header>
        <div class="navbar">
            <div class="account">
                <div class="account-dropdown">
                    <ul id="#settings">
                        <li></li>
                    </ul>
                </div>
            </div>
            <div class="sections">
                <a href="http://localhost/index.html">DefaultCube</a>
                <input id="burgermenu" type="checkbox" />
                <div class="burger">
                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3"></div>
                </div>
                <ul class="dropdown">
                    <li><a href="http://localhost/pages/shop.php">Products</a></li>
                    <li><a href="">Become a Cuber</a></li>
                    <li><a href="">News</a></li>
                </ul>
            </div>
            <div class="cart">
                <a class="cart-img" href="http://localhost/pages/cart.php"></a>
            </div>
        </div>
    </header>

    <br><br><br><br><br>

    <h1 style="font-size: 45px; margin: 20px">Products</h1>
    <section class="store">
        <?php require('../php/products.php'); ?>
    </section>

    <footer class="footer">
        <form method="POST">
            <input type="submit" name="DeleteCookie" value="Cancella Cookie" />
        </form>
    </footer>
</body>

</html>