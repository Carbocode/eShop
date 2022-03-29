<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>DefaultCube</title>
    <link rel="stylesheet" href="css\style.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/script.js"></script>
</head>

<body>
    <?php require('php/timeCookie.php')?>
    <?php require('php/database.php'); ?>

    <header>
        <div class="navbar">
            <div class="account">
                <div class="account-dropdown">
                    <ul id="#settings">
                    </ul>
                </div>
            </div>
            <div class="sections">
                <a href="http://localhost/index.php">DefaultCube</a>
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
                <a class="cart-img" href="http://localhost/pages/cart.php"></a>
            </div>
        </div>
    </header>

    <div class="header__image">
        <div class="header__image__text">COMPRA IL TUO CUBO</div>
    </div>

    <h1 style="font-size: 45px; margin: 20px">Products</h1>
    <section class="store">
        <?php require('php/products.php'); ?>
    </section>

    <footer class="footer">
        <form method="POST">
            <input type="submit" name="DeleteCookie" value="Cancella Cookie" />
        </form>
    </footer>
</body>

</html>