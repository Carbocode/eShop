<?php

if(isset($_POST['DeleteCookie'])){
    if (isset($_COOKIE['ultimavisita'])) {
        unset($_COOKIE['ultimavisita']);
        setcookie('ultimavisita', null);
    }
}
?>