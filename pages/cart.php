<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Title</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>

    <header>
        <div class="navbar">
            <div class="account">
                <div class="account-dropdown">
                    <ul id="#settings">
                        <script>
                        $(document).ready(function() {
                            $.ajax({
                                type: "POST",
                                url: "http://localhost/php/loadSettings.php",
                                success: function(res) {
                                    document.getElementById("#settings").innerHTML = res;
                                },
                            });
                        });

                        function logout(e) {
                            e.preventDefault();
                            $.ajax({
                                type: "POST",
                                url: "http://localhost/php/loadSettings.php",
                                data: {
                                    Logout: new Boolean(true),
                                },
                                success: function(res) {
                                    alert("You have been disconnected");
                                    window.location.href = "http://localhost/index.php";
                                },
                            });
                        }
                        </script>
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

</body>

</html>