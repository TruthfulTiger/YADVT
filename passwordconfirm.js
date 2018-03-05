var password = document.getElementById("input2PasswordForm")
    , confirm_password = document.getElementById("verifyPassword2Form");

function validatePassword(){
    if(password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Passwords Don't Match");
    } else {
        confirm_password.setCustomValidity('');
    }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;

// Reference: https://codepen.io/diegoleme/pen/surIK