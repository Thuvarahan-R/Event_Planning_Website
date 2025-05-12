<!--
  File Name: createevent.php
  Created By: Simon Tan (041 161 622), Thuvarahan Ragunathan (041 137 420)
  Date Created: March 30th, 2025
  Description: The page containing the form for users to create an event on Eventsite.
-->

<?php
  session_start();
  require_once "../../private/functions/connection.php";
  $database = db_connect();

  if(!isset($_SESSION['Email'])) {
    header("Location: login.php");
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Simon Tan">
  <meta name="keywords" content="create event, Eventsite, new">
  <meta name="description" content="The create event page for Eventsite">
  <link rel="stylesheet" href="../css/general.css" type="text/css">
  <script src="../scripts/createevent.js" defer></script>
  <title>Eventsite - Create Event</title>
</head>

<body>
  <?php 
    include "../../private/functions/loggedinheader.php";
  ?>
  
  <main class="eventbackground2">
    <div class="formcontainer">
    <a class="smallbutton" href="yourevents.php">Back to Your Events</a>
      <h1>Create New Event</h1>
      <form action="validateevent.php" method="POST" onsubmit="return validate();">
        <fieldset>
          <legend>Event Details</legend>
          <div class="formfield">
            <label for="eventname">Event Name</label>
            <input type="text" name="eventname" id="eventname">
          </div>
          <div class="formfield">
            <label for="eventtype">Event Type</label>
            <select name="eventtype" id="eventtype">
              <?php
                $sql = "SELECT * FROM EVENT_TYPE;";
                $result_set = mysqli_query($database, $sql);
                while ($results = mysqli_fetch_assoc($result_set)) {
                  echo '<option value="' . $results["Event_Type_Id"] . 
                        '" selected>' . $results["Type"] . '</option>';
                }
                db_disconnect($database);
              ?>
            </select>
          </div>
          <div class="formfield">
            <label for="eventstart">Start Date</label>
            <input type="datetime-local" name="eventstart" id="eventstart">
          </div>
          <div class="formfield">
            <label for="eventend">End Date</label>
            <input type="datetime-local" name="eventend" id="eventend">
          </div>
          <div class="formfield">
            <label for="visibility">Visibility (Who can see your event?)</label>
            <select name="visibility" id="visibility">
              <option value="Public">Public</option>
              <option value="Private">Private</option>
            </select>
          </div>
        </fieldset>
        <fieldset>
          <legend>Location</legend>
          <div class="formfield">
            <label for="address">Address</label>
            <input type="text" name="address" id="address">
          </div>
          <div class="formfield">
            <label for="province">Province</label>
            <select name="province" id="province">
              <option value="AB">Alberta</option>
              <option value="BC">British Colombia</option>
              <option value="MB">Manitoba</option>
              <option value="NB">New Brunswick</option>
              <option value="NL">Newfoundland and Labrador</option>
              <option value="NS">Nova Scotia</option>
              <option value="ON" selected>Ontario</option>
              <option value="PE">Prince Edward Island</option>
              <option value="QC">Quebec</option>
              <option value="SK">Saskatchewan</option>
            </select>
          </div>
          <div class="formfield">
            <label for="city">City</label>
            <input type="text" name="city" id="city">
          </div>
          <div class="formfield">
            <label for="postalcode">Postal Code</label>
            <input type="text" name="postalcode" id="postalcode">
          </div>
        </fieldset>
        <fieldset>
          <legend>Description</legend>
          <label for="description">Enter event details here...</label>
          <textarea name="description" id="description"></textarea>
        </fieldset>
        <button type="submit">Create Event</button>
      </form>
    </div>
  </main>

  <?php
    include "../../private/functions/footer.php"
  ?>
</body>