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
                <a href="/">DefaultCube</a>
                <input id="burgermenu" type="checkbox" />
                <div class="burger">
                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3"></div>
                </div>
                <ul class="dropdown">
                    <li><a href="/pages/shop">Prodotti</a></li>
                    <li><a href="">Diventa un Cuber</a></li>
                    <li><a href="">Notizie</a></li>
                    <div id="google_translate_element"></div>
                    <script type="text/javascript"
                        src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                    <script type="text/javascript">
                    function googleTranslateElementInit() {
                        new google.translate.TranslateElement({
                                pageLanguage: "it",
                            },
                            "google_translate_element"
                        );
                    }
                    </script>
                </ul>
            </div>
            <div class="cart">
                <a class="cart-img" href="/pages/cart"></a>
            </div>
        </div>
    </header>
    <br>

    <h1 style="font-size: 45px; margin: 100px 20px 20px 20px;">Prodotti</h1>
    <section class="store">
        <?php require('../api/products.php');
        ?>
    </section>

    <script>
    function fullScreen(lol) {
        $('body').append(
            `<div class="screen-fixed">
            <div onclick="closeScreen()" class="screen-header-button">+</div>
            <div class="screen">
                <div class="screen-body">
                    <div class="screen-body-item left" style="color:black;">
                    Qui ci va il visualizzatore dei modelli 3D
                    </div>
                    <div class="screen-body-item right">
                    ${lol.innerHTML}
                    <div>${lol.dataset.description}</div>
                    <button onclick="addToCart(this)" style='width:50%; margin:auto;'>${lol.dataset.id}</button>
                    </div>
                </div>
            </div>
        </div>`);

    }

    function addToCart(lol) {
        cookie = getCookie("cart");
        if (cookie != "") {
            obj = JSON.parse(cookie)
            obj.products.push(lol.innerHTML)
            cookie = JSON.stringify(obj)
            setCookie("cart", cookie, 365);
        } else {
            cart = JSON.stringify({
                "products": [lol.innerHTML]
            })
            setCookie("cart", cart, 365);
        }

    }

    function closeScreen() {
        $(".screen-fixed").remove()
    }
    </script>

</body>

</html>