<?php

if(isset($_POST['DeleteCookie'])){
    if (isset($_COOKIE['ultimavisita'])) {
        unset($_COOKIE['ultimavisita']);
        setcookie('ultimavisita', null);
    }
}

if(isset($_COOKIE['ultimavisita'])) {
    print "<div style='background-color:orange;'>Accesso eseguito in data: ".$_COOKIE['ultimavisita']."</div>";
}
?>