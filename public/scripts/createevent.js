/*
    File Name: createevent.js
    Created By: Simon Tan (041 161 622), Thuvarahan Ragunathan (041 137 420)
    Date Created: March 30th, 2025
    Description: Javascript file for createevent.php. Provides form validation
    and gives real-time feedback to users based on their input in the form fields.
*/

const eventname = document.getElementById("eventname");
eventname.addEventListener("input", checkEventName);
let goodEventName = false;

const eventstart = document.getElementById("eventstart");
eventstart.addEventListener("input", checkStartDates);
let goodEventStart = false;

const eventend = document.getElementById("eventend");
eventend.addEventListener("input", checkEndDates);
let goodEventEnd = false;

const address = document.getElementById("address");
address.addEventListener("input", checkAddress);
let goodAddress = false;

const city = document.getElementById("city");
city.addEventListener("input", checkCity);
let goodCity = false;

const postalcode = document.getElementById("postalcode");
postalcode.addEventListener("input", checkPostalCode);
let goodPostal = false;

const description = document.getElementById("description");
description.addEventListener("input", checkDescription);
let goodDescription = false;

function validate() {
    checkEventName();
    checkStartDates();
    checkEndDates();
    checkAddress();
    checkCity();
    checkPostalCode();
    checkDescription();

    if (goodEventName && goodEventStart && goodEventEnd && 
            goodAddress && goodCity && goodPostal && goodDescription){
        eventname.value = eventname.value.trim();
        address.value = address.value.trim();
        city.value = city.value.trim();
        postalcode.value = postalcode.value.toUpperCase();
        description.value = description.value.trim();
        return true;
    }
    else {
        return false;
    }
}

function checkEventName() {
    removeError(eventname);

    if (eventname.value.trim().length > 0 && eventname.value.trim().length <= 100) {
        goodEventName = true;
    } else {
        goodEventName = false;
        showError(eventname, "Event name is required and should be less than 100 characters.");
    }
}

function checkStartDates() {
    const dateRegex = /^[1-2]\d{3}-[01]\d-[0-3]\dT[0-2]\d:[0-6]\d$/;

    removeError(eventstart);

    const startValue = eventstart.value;

    const now = new Date();

    if (!startValue) {
        goodEventStart = false;
        showError(eventstart, "Start date is required.");
    } else if (!dateRegex.test(startValue)) {
        goodEventStart = false;
        showError(eventstart, "Invalid start date format. Use YYYY-MM-DD HH:MM.");
    } else if (new Date(startValue) <= now) {
        goodEventStart = false;
        showError(eventstart, "Start date and time must be in the future.");
    } else {
        goodEventStart = true;
    }
}

function checkEndDates() {
    const dateRegex = /^[1-2]\d{3}-[01]\d-[0-3]\dT[0-2]\d:[0-6]\d$/;

    removeError(eventend);

    const endValue = eventend.value;
    const startValue = eventstart.value;

    if (!endValue) {
        goodEventEnd = false;
        showError(eventend, "End date is required.");
    } else if (!dateRegex.test(endValue)) {
        goodEventEnd = false;
        showError(eventend, "Invalid end date format. Use YYYY-MM-DD HH:MM.");
    } else if (new Date(startValue) >= new Date(endValue)) {
        goodEventEnd = false;
        showError(eventend, "End date must be after start date.");
    } else {
        goodEventEnd = true;
    }
}

function checkAddress() {
    removeError(address);

    if (address.value.trim().length > 0) {
        goodAddress = true;
    } else {
        goodAddress = false;
        showError(address, "Address must not be empty.");
    }
}

function checkCity() {
    removeError(city);

    if (city.value.trim().length > 0) {
        goodCity = true;
    } else {
        goodCity = false;
        showError(city, "City must not be empty.");
    }
}

function checkPostalCode() {
    removeError(postalcode);

    if (postalcode.value.trim().match(/^[A-Za-z]\d[A-Za-z]\d[A-Za-z]\d$/)) {
        goodPostal = true;
    } else {
        goodPostal = false;
        showError(postalcode, "Please enter a valid Canadian postal code (e.g., K2A6B3).");
    }
}

function checkDescription() {
    removeError(description);

    if (description.value.trim().length > 0) {
        goodDescription = true;
    } else {
        goodDescription = false;
        showError(description, "Description must not be empty.")
    }
}

function showError(element, message) {
    const errormessage = document.createElement("div");
    errormessage.className = "errormessage";
    errormessage.innerHTML = `&#128939; ${message}`;
    element.after(errormessage);
    element.style.borderColor = "red";
    element.style.borderWidth = "3px";
}

function removeError(element) {
    if (element.nextElementSibling && element.nextElementSibling.classList.contains("errormessage")) {
        element.nextElementSibling.remove();
    }
    element.style.borderColor = "grey";
    element.style.borderWidth = "1px";
}
