$(document).ready(loadSettings(0));
$("#logout").click(logout());

function loadSettings(jwt) {
    $.ajax({
        type: "POST",
        contentType: "application/json; charset=utf-8",
        url: "http://localhost/api/loadSettings.php",
        data: JSON.stringify({jwt:jwt}),
        dataType: "JSON",
        encode: true,
        success: function(res) {
            document.getElementById("#settings").innerHTML = res.settings;
            if (res.alert != "")
                alert(res.alert);
        },
    });
}

function logout(e) {
    $.ajax({
        type: "POST",
        contentType: "application/json; charset=utf-8",
        url: "http://localhost/api/loadSettings.php",
        data: JSON.stringify({logout: true}),
        dataType: "JSON",
        encode: true,
        success: function(res) {
            document.getElementById("#settings").innerHTML = res.settings;
            if (res.alert != "")
                alert(res.alert);
        },
    });
}