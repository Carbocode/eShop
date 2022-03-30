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
            window.location.href = "http://localhost/index.html";
        },
    });
}