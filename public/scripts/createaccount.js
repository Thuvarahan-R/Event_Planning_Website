/*
    File Name: createaccount.js
    Created By: Simon Tan (041 161 622), Thuvarahan Ragunathan (041 137 420)
    Date Created: March 30th, 2025
    Description: Javascript file for createaccount.php. Provides form validation
    and gives real-time feedback to users based on their input in the form fields.
*/

const email = document.getElementById("email");
email.addEventListener("input", checkEmail);
let goodEmail = false;

const fname = document.getElementById("fname");
fname.addEventListener("input", checkFname); 
let goodfname = false;

const lname = document.getElementById("lname");
lname.addEventListener("input", checkLname); 
let goodlname = false;

const password = document.getElementById("password");
password.addEventListener("input", checkPassword);
let goodPassword = false;

const confirmPassword = document.getElementById("confirmpassword");
confirmPassword.addEventListener("input", checkConfirmPassword);
let goodConfirmPassword = false;

function validate() {
    checkEmail();
    checkFname();
    checkPassword(); 
    checkConfirmPassword();
    checkLname();
    if (goodEmail && goodfname && goodlname && goodPassword && goodConfirmPassword) {
        return true;
    } else {
        return false;
    }
}

function checkEmail() {
    if (email.nextElementSibling) {
        email.nextElementSibling.remove();
        email.style.borderColor = "grey";
        email.style.borderWidth = "1px";
    }

    if (email.value.match(/^[\w.\-]+@[\w\-]+\.[\w]+$/)) {
        goodEmail = true;
    } else {
        goodEmail = false;
        let errormessage = document.createElement("div");
        errormessage.className = "errormessage";
        errormessage.innerHTML = "&#128939; Email address should be non-empty with the " + 
                                    "format xyz@xyz.xyz. Can only contain special characters " + 
                                    "\" - \" and  \" . \"";
        email.after(errormessage);
        email.style.borderColor = "red";
        email.style.borderWidth = "3px";
    }
}

function checkFname() {
    if (fname.nextElementSibling) {
        fname.nextElementSibling.remove();
        fname.style.borderColor = "grey";
        fname.style.borderWidth = "1px";
    }

    if (fname.value.match(/^[a-zA-Z\-\']{1,30}$/)) {
        goodfname = true;
    } else {
        goodfname = false;
        let errormessage = document.createElement("div");
        errormessage.className = "errormessage";
        errormessage.innerHTML = "&#128939; First name should be non-empty, and within 30 characters long.";
        fname.after(errormessage);
        fname.style.borderColor = "red";
        fname.style.borderWidth = "3px";
    }
}

function checkLname() {
    if (lname.nextElementSibling) {
        lname.nextElementSibling.remove();
        lname.style.borderColor = "grey";
        lname.style.borderWidth = "1px";
    }

    if (lname.value.match(/^[a-zA-Z\-\']{1,30}$/)) {
        goodlname = true;
    } else {
        goodlname = false;
        let errormessage = document.createElement("div");
        errormessage.className = "errormessage";
        errormessage.innerHTML = "&#128939; Last name should be non-empty, and within 30 characters long.";
        lname.after(errormessage);
        lname.style.borderColor = "red";
        lname.style.borderWidth = "3px";
    }
}

function checkPassword() {
    if (password.nextElementSibling) {
        password.nextElementSibling.remove();
        password.style.borderColor = "grey";
        password.style.borderWidth = "1px";
    }

    if (password.value.match(/^\S{8,}$/)) {
        goodPassword = true;
    } else {
        goodPassword = false;
        let errormessage = document.createElement("div");
        errormessage.className = "errormessage";
        errormessage.innerHTML = "&#128939; Password should be at least 8 characters and contain no spaces.";
        password.after(errormessage);
        password.style.borderColor = "red";
        password.style.borderWidth = "3px";
    }
}

function checkConfirmPassword() {
    if (confirmPassword.nextElementSibling) {
        confirmPassword.nextElementSibling.remove();
        confirmPassword.style.borderColor = "grey";
        confirmPassword.style.borderWidth = "1px";
    }

    if (confirmPassword.value === password.value && confirmPassword.value.length > 0) {
        goodConfirmPassword = true;
    } else {
        goodConfirmPassword = false;
        let errormessage = document.createElement("div");
        errormessage.className = "errormessage";
        errormessage.innerHTML = "&#128939; Passwords should match exactly";
        confirmPassword.after(errormessage);
        confirmPassword.style.borderColor = "red";
        confirmPassword.style.borderWidth = "3px";
    }
}