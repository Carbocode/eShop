loadSettings()

function loadSettings() {
    $.ajax({
        type: "POST",
        contentType: "application/json; charset=utf-8",
        url: "http://localhost/api/loadSettings.php",
        headers: {"Authorization": localStorage.getItem('token')},
        dataType: "JSON",
        encode: true,
        success: function(res) {
            document.getElementById("#settings").innerHTML = res.settings;
            if (res.alert != "")
                alert(res.alert);
        },
    });
}

function logout() {
    localStorage.clear();
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