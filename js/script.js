$( document ).ready(loadSettings());

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }

  function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }

function loadSettings() {
    $.ajax({
        type: "POST",
        contentType: "application/json; charset=utf-8",
        url: "http://localhost/api/loadSettings.php",
        headers: {"Authorization": sessionStorage.getItem('token')},
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
    sessionStorage.removeItem("token")
    $.ajax({
        type: "POST",
        contentType: "application/json; charset=utf-8",
        url: "http://localhost/api/loadSettings.php",
        headers: {"Authorization": sessionStorage.getItem('token')},
        data: JSON.stringify({logout: true}),
        dataType: "JSON",
        encode: true,
        success: function(res) {
            document.getElementById("#settings").innerHTML = res.settings;
            
            localStorage.setItem("logoutAll", String(Date.now()))
            
            if (res.alert != "")
                alert(res.alert);
        },
    });
}

if (!sessionStorage.length) {
    // Ask other tabs for session storage
    localStorage.setItem("getSessionStorage", String(Date.now()))
}

window.addEventListener("storage", (event) => {
    if (event.key == "logoutAll") {
        sessionStorage.removeItem("token")
    }
   loadSettings()
})

window.addEventListener("storage", (event) => {
     if (event.key == "getSessionStorage") {
        // Some tab asked for the sessionStorage -> send it
        localStorage.setItem("sessionStorage", JSON.stringify(sessionStorage))
        localStorage.removeItem("sessionStorage")
    } else if (event.key == "sessionStorage" && !sessionStorage.length) {
        // sessionStorage is empty -> fill it
        const data = JSON.parse(event.newValue)
        for (let key in data) {
            sessionStorage.setItem(key, data[key])
        }
    }
    loadSettings()
})