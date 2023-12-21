function getQueryParam(name) {
    const urlSearchParams = new URLSearchParams(window.location.search);
    return urlSearchParams.get(name);
}

// Check if login error is set in the query parameters
var loginError = getQueryParam('login_error');
if (loginError === '1') {
    alert("Incorrect password");
} 
// else if (loginError === '2') {
//     alert("No User with this email found");
// }
