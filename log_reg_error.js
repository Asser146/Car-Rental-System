function getQueryParam(name) {
    const urlSearchParams = new URLSearchParams(window.location.search);
    return urlSearchParams.get(name);
}

// Check if login error is set in the query parameters
var loginError1 = getQueryParam('login_error1');
var loginError2 = getQueryParam('login_error2');
var registerationError = getQueryParam('register_error');

if (loginError1 === '1') {
    alert("Incorrect email or pass");
} 
if (loginError2 === '1') {
    alert("No User with this email found");
}
if(registerationError === '1'){
    alert("This user already exists");
}
