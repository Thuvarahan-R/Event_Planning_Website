/*
    File Name: displayevent.js
    Created By: Simon Tan (041 161 622), Thuvarahan Ragunathan (041 137 420)
    Date Created: March 30th, 2025
    Description: Javascript file for displayevent.php. Adds function to ask 
    users for confirmation before unregistering from an event or deleting an
    event.
*/

//a maximum of one element will have the id deletebutton in displayevent.php
const deleteButton = document.getElementById("deletebutton");

//only add event listener if element exists
if (deleteButton != null) {
  deleteButton.addEventListener("click", confirmChoice);
}

/*
  Function that uses confirm() function to ask for user confirmation in a pop-up window.
  Will give different confirmation messages based on the text of the link.
*/
function confirmChoice(event) {
  if (deleteButton.text == "Delete Event") {
    choice = confirm("Are you sure you want to delete this event?");
    if (choice) {
      return true;
    }
    else {
      event.preventDefault();
    }
  }
  else if (deleteButton.text == "Cancel Registration") {
    choice = confirm("Are you sure you want to unregister from this event?");
    if (choice) {
      return true;
    }
    else {
      event.preventDefault();
    }
  }
}