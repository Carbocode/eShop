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
                <a href="http://localhost">DefaultCube</a>
                <input id="burgermenu" type="checkbox" />
                <div class="burger">
                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3"></div>
                </div>
                <ul class="dropdown">
                    <li><a href="http://localhost/pages/shop">Products</a></li>
                    <li><a href="">Become a Cuber</a></li>
                    <li><a href="">News</a></li>
                </ul>
            </div>
            <div class="cart">
                <a class="cart-img" href="http://localhost/pages/cart"></a>
            </div>
        </div>
    </header>

    <br><br><br><br><br>

    <section>
        <div class="screen screen-fixed">
            <div class="screen-header">
                <div class="screen-header-left">
                    <div class="screen-header-button close"></div>
                    <div class="screen-header-button maximize"></div>
                    <div class="screen-header-button minimize"></div>
                </div>
            </div>
            <div class="screen-body">
                <div class="screen-body-item left" style="background-image: url(../userImg/products/0age.jpg);">

                </div>
                <div class="screen-body-item">

                </div>
            </div>
        </div>
    </section>

    <h1 style="font-size: 45px; margin: 20px">Products</h1>
    <section class="store">
        <?php require('../php/products.php'); ?>
    </section>

</body>

</html>