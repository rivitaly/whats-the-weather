var form = document.getElementById("signin-form");
form.addEventListener("submit", validateLogin);

function validateUsername(v_username) {
    var unameRegEx = /^[a-zA-Z0-9_]+$/;
    return (unameRegEx.test(v_username))
}

function validateLogin(event) {
    var user = document.getElementById("username");
    var pass = document.getElementById("password");
    var flag = true;

    if (!validateUsername(user.value)) {
        document.getElementById(user.id).classList.add("input-error");
        document.getElementById("error-text-" + user.id).classList.remove("hidden");
        flag = false;
    }
    else {
        document.getElementById(user.id).classList.remove("input-error");
        document.getElementById("error-text-" + user.id).classList.add("hidden");
    }
    if (pass.value.length < 7) {
        document.getElementById(pass.id).classList.add("input-error");
        document.getElementById("error-text-" + pass.id).classList.remove("hidden");
        flag = false;
    }
    else {
        document.getElementById(pass.id).classList.remove("input-error");
        document.getElementById("error-text-" + pass.id).classList.add("hidden");
    }

    if (flag === false)
        event.preventDefault();
    //else
        //console.log("validation successfull, sending data to the server");
}