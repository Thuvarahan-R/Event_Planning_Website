/*
    File Name: login.js
    Created By: Simon Tan (041 161 622), Thuvarahan Ragunathan (041 137 420)
    Date Created: March 30th, 2025
    Description: Javascript file for login.php. Provides form validation
    and gives real-time feedback to users based on their input in the form fields.
*/

const email = document.getElementById("email");
email.addEventListener("input", checkEmail);
let goodEmail = false;

const password = document.getElementById("password");
password.addEventListener("input", checkPassword);
let goodPassword = false;

function validateLogin() {
    checkEmail();
    checkPassword();
    if (goodEmail && goodPassword) {
        return true;
    } else {
        return false;
    }
}

function checkEmail() {
    if (email.nextElementSibling) {
        email.nextElementSibling.remove();
        resetStyle(email);
    }

    if (email.value.match(/^[\w.\-]+@[\w\-]+\.[\w]+$/)) {
        goodEmail = true;
    } else {
        goodEmail = false;
        showError(email, "&#128939; Email address should be non-empty with the " + 
                        "format xyz@xyz.xyz. Can only contain special characters " + 
                        "\" - \" and  \" . \"");
    }
}

function checkPassword() {
    if (password.nextElementSibling) {
        password.nextElementSibling.remove();
        resetStyle(password);
    }

    if (password.value.match(/^\S{8,}$/)) {
        goodPassword = true;
    } else {
        goodPassword = false;
        showError(password, "&#128939; Password must be at least 8 characters and contain no spaces.");
    }
}

function showError(inputElement, message) {
    let errormessage = document.createElement("div");
    errormessage.className = "errormessage";
    errormessage.innerHTML = message;
    inputElement.after(errormessage);
    inputElement.style.borderColor = "red";
    inputElement.style.borderWidth = "3px";
}

function resetStyle(inputElement) {
    inputElement.style.borderColor = "grey";
    inputElement.style.borderWidth = "1px";
}
