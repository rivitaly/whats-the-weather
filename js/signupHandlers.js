var username = document.getElementById("username");
var password = document.getElementById("password");
var re_password = document.getElementById("re-password");

username.addEventListener("blur", usernameHandler);
password.addEventListener("blur", passwordHandler);
re_password.addEventListener("blur", re_passwordHandler);

function validateUsername(v_username) {
    var unameRegEx = /^[a-zA-Z]+$/;
    return (unameRegEx.test(v_username))
}

function usernameHandler(event) {
    var user = event.target;
    if (!validateUsername(user.value)) {
        document.getElementById(user.id).classList.add("input-error");
        document.getElementById("error-text-" + user.id).classList.remove("hidden");
    }
    else {
        document.getElementById(user.id).classList.remove("input-error");
        document.getElementById("error-text-" + user.id).classList.add("hidden");
    }
}

function passwordHandler(event) {
    var pass = event.target;
    if (pass.value.length < 7) {
        document.getElementById(pass.id).classList.add("input-error");
        document.getElementById("error-text-" + pass.id).classList.remove("hidden");
    }
    else {
        document.getElementById(pass.id).classList.remove("input-error");
        document.getElementById("error-text-" + pass.id).classList.add("hidden");
    }
}

function re_passwordHandler(event) {
    var pass = document.getElementById("password")
    var re_pass = event.target
    if (pass.value !== re_pass.value) {
        document.getElementById(re_pass.id).classList.add("input-error");
        document.getElementById("error-text-" + re_pass.id).classList.remove("hidden");
    }
    else {
        document.getElementById(re_pass.id).classList.remove("input-error");
        document.getElementById("error-text-" + re_pass.id).classList.add("hidden");
    }
}


