<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>DefaultCube</title>
    <link rel="stylesheet" href="../css/style.css" />
    <script src="https://kit.fontawesome.com/7ad7bfae68.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../js/script.js"></script>
</head>

<body>
    <header>
        <div class="navbar">
            <div class="account">
                <input id="account-dropdown" type="checkbox" />
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
                    <li>
                        <a href="/pages/shop"><i class="fa-solid fa-store"></i>Prodotti</a>
                    </li>
                    <li>
                        <a href=""><i class="fa-solid fa-cubes"></i>Diventa un Cuber</a>
                    </li>
                    <li>
                        <a href=""><i class="fa-solid fa-newspaper"></i>Notizie</a>
                    </li>
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
        $('body').css({
            overflow: 'hidden'
        });
        $('body').append(
            `<div class="screen-fixed">
            <div onclick="closeScreen()" class="screen-header-button"><i class="fa-solid fa-xmark"></i></div>
            <div class="screen">
                <div class="screen-body">
                    <div class="screen-body-item left" style="color:black;">
                    Qui ci va il visualizzatore dei modelli 3D
                    </div>
                    <div class="screen-body-item right">
                    ${lol.innerHTML}
                    <p style='padding:10px; margin-bottom: 30px'>${lol.dataset.description}</p>
                    <button onclick="addToCart(${lol.dataset.id})" style='width:50%; margin: 10px auto; padding: 5px'>Aggiungi al carrello</button>
                    </div>
                </div>
            </div>
        </div>`);

    }

    function addToCart(lol) {
        cookie = getCookie("cart");
        if (cookie != "") {
            obj = JSON.parse(cookie)
            cookie = getCookie("cart");
            obj = JSON.parse(cookie);

            alreadyExisting = false;
            for (var i = 0; i < obj.products.length; i++) {
                if (obj.products[i] == lol) {
                    alreadyExisting = true;
                    alert("Prodotto già nel carrello");
                    break;
                }
            }
            if (!alreadyExisting) {
                obj.products.push(lol);
                cookie = JSON.stringify(obj)
                setCookie("cart", cookie, 365);
            }
        } else {
            cart = JSON.stringify({
                "products": [lol]
            })
            setCookie("cart", cart, 365);
        }

    }

    function closeScreen() {
        $(".screen-fixed").remove()
        $('body').css({
            overflow: 'scroll'
        });
    }
    </script>

</body>

</html>