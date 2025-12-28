$( document ).ready(loadSettings());

if (sessionStorage.getItem("token") === null) { 
        document.cookie = 'ident=; Max-Age=-99999999;';
  }

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
        url: "/api/loadSettings.php",
        headers: {"Authorization": sessionStorage.getItem('token')},
        dataType: "JSON",
        encode: true,
        success: function(res) {
            document.getElementById("#settings").innerHTML = res.settings;
            if (res.alert != "")
                alert(res.alert);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            if (errorThrown != "") alert(errorThrown);
          },
    });
}

function loadLogin(e) {
    e.preventDefault()
    closeScreen()
    $('body').css({
        overflow: 'hidden'
    });
    $('body').append(
        `<section class="screen-fixed">
        <div onclick="closeScreen()" class="screen-header-button"><i class="fa-solid fa-xmark"></i></div>
        <fieldset class="screen-body-item">
          <legend>Entra</legend>
          <form class="app-form">
            <div class="app-form-group">
              <fieldset>
                <legend>Username</legend>
                <input
                  name="username"
                  id="username"
                  placeholder="Username"
                  autofocus
                  required
                />
              </fieldset>
            </div>
            <div class="app-form-group">
              <fieldset>
                <legend>Password</legend>
                <input
                  type="password"
                  name="password"
                  id="password"
                  placeholder="Password"
                  minlength="8"
                  required
                />
              </fieldset>
            </div>
            <div class="app-form-group buttons">
              <input
                type="submit"
                name="Signin"
                id="Signin"
                onclick="login(event)"
                value="Sign-In"
              />
            </div>
          </form>
        </fieldset>
        <div id="risultato"></div>
      </section>`);
}

function loadRegister(e) {
    e.preventDefault()
    closeScreen()
    $('body').css({
        overflow: 'hidden'
    });
    $('body').append(
        `<section class="screen-fixed">
        <div onclick="closeScreen()" class="screen-header-button"><i class="fa-solid fa-xmark"></i></div>
        <fieldset class="screen-body-item">
          <legend>Registrati</legend>
          <form class="app-form">
            <div class="app-form-group">
              <fieldset>
                <legend>Nome</legend>
                <input
                  name="name"
                  id="name"
                  class="app-form-control"
                  placeholder="Nome"
                  autofocus
                  required
                />
              </fieldset>
            </div>
            <div class="app-form-group">
              <fieldset>
                <legend>Cognome</legend>
                <input
                  name="surname"
                  id="surname"
                  class="app-form-control"
                  placeholder="Cognome"
                  required
                />
              </fieldset>
            </div>
            <div class="app-form-group message">
              <fieldset>
                <legend>Username</legend>
                <input
                  name="username"
                  id="username"
                  class="app-form-control"
                  placeholder="Username"
                  required
                />
              </fieldset>
            </div>
            <div class="app-form-group">
              <fieldset>
                <legend>E-Mail</legend>
                <input
                  type="email"
                  id="email"
                  name="email"
                  class="app-form-control"
                  placeholder="E-Mail"
                  required
                />
              </fieldset>
            </div>
            <div class="app-form-group message">
              <fieldset>
                <legend>Password</legend>
                <input
                  type="password"
                  id="password"
                  name="password"
                  class="app-form-control"
                  placeholder="Password"
                  minlength="8"
                  required
                />
              </fieldset>
            </div>
            <div class="app-form-group buttons">
              <input
                type="submit"
                name="Signup"
                id="Signup"
                onclick="register(event)"
                class="app-form-button"
                value="Sign-Up"
              />
            </div>
          </form>
        </fieldset>
      </section>`);
}

function register(e) {
    e.preventDefault();

    $.ajax({
      type: "POST",
      contentType: "application/json; charset=utf-8",
      url: "/api/register.php",
      data: JSON.stringify({
        name: $("#name").val(),
        surname: $("#surname").val(),
        username: $("#username").val(),
        email: $("#email").val(),
        password: $("#password").val(),
      }),
      dataType: "JSON",
      encode: true,
      success: function (res) {
        if (res.alert != "") alert(res.alert);
        window.location.href = "/";
      },
      error: function (jqXHR, textStatus, errorThrown) {
        if (errorThrown != "") alert(errorThrown);
      },
    });
}

function login(e) {
e.preventDefault();
$.ajax({
    type: "POST",
    contentType: "application/json; charset=utf-8",
    url: "/api/login.php",
    data: JSON.stringify({
    username: $("#username").val(),
    password: $("#password").val(),
    }),
    dataType: "JSON",
    encode: true,
    success: function (res) {
    if (res.jwt != "") sessionStorage.setItem("token", res.jwt);
    if (res.alert != "") alert(res.alert);
    window.location.href = "/";
    },
    error: function (jqXHR, textStatus, errorThrown) {
    if (errorThrown != "") alert(errorThrown);
    },
});
}

function logout() {
    sessionStorage.removeItem("token")
    $.ajax({
        type: "POST",
        contentType: "application/json; charset=utf-8",
        url: "/api/loadSettings.php",
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
        error: function (jqXHR, textStatus, errorThrown) {
            if (errorThrown != "") alert(errorThrown);
          },
    });
}

function closeScreen() {
    $(".screen-fixed").remove()
    $('body').css({
        overflow: 'scroll'
    });
}

if (!sessionStorage.length) {
    // Ask other tabs for session storage
    localStorage.setItem("getSessionStorage", String(Date.now()))
}

window.addEventListener("storage", (event) => {
    if (event.key == "logoutAll") {
        sessionStorage.removeItem("token")
        setCookie("ident", null, -99999999);
        setCookie("cart", null, -99999999);
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
