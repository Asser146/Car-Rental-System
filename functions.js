function getQueryParam(name) {
    const urlSearchParams = new URLSearchParams(window.location.search);
    return urlSearchParams.get(name);
}

// Check if login error is set in the query parameters
const loginError = getQueryParam('login_error');
if (loginError && loginError === '1') {
    alert("Incorrect email or password");
}

function validateLogin() {
    if (document.getElementById("login_1").value == "") {
        alert('Write your Email !')
        return false
    }
    else {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailInput)) {
            return false;
        }
    }
    if (document.getElementById("login_2").value == "") {
        alert('Write your Password !');
        return false;
    }
    return true;
}


function validateRegister() {
    if (document.getElementById("reg1").value == "") {
        alert('Write your First Name !')
        return false
    }
    else if (document.getElementById("reg2").value == "") {
        alert('Write your Last Name !')
        return false
    }
    else if (document.getElementById("reg3").value == "") {
        alert('Write your Email !');
        return false;
    }
    else if (document.getElementById("reg4").value == "") {
        alert('Write your Password !');
        return false;
    }
    else if (document.getElementById("reg5").value == "") {
        alert('Write your Confirmation of Password !');
        return false;
    }
    else {
        if (document.getElementById("reg5").value == document.getElementById("reg4").value)
            return true;
        else {
            alert('Passwords Miss-Match!');
            return false;
        }
    }
}
