export default function Header(){
    return (
            <div class="navbar">
                <div class="account">
                    <div class="account-dropdown">
                        <ul>
                            <li><a href="pages/signin.php">Log-In</a></li>
                            <li><a>Log-Out</a></li>
                            <li><a href="pages/signup.php">Register</a></li>
                            <li><a href="pages/addProduct.php">Sell</a></li>
                            <li><a>Profile</a></li>
                            <li><a>Settings</a></li>
                            <li><a>Orders</a></li>
                        </ul>
                    </div>
                </div>
                <div class="sections">
                    <a href="index.php">DefaultCube</a>
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
                    <a href="pages/cart.php"><img src="img/shopping-cart.png" /></a>
                </div>
            </div>
    )
}