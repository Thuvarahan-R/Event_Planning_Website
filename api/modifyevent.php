<!--
  File Name: modifyevent.php
  Created By: Simon Tan (041 161 622), Thuvarahan Ragunathan (041 137 420)
  Date Created: March 30th, 2025
  Description: PHP page containing the form used to modify informaiton from an 
  existing event.
-->

<?php
  session_start();
  require_once "../../private/functions/connection.php";
  $database = db_connect();

  if(!isset($_SESSION['Email'])) {
    header("Location: login.php");
  }
  $eventid = $_GET['eventid'];
  //Query to get general event information and owner
  $sql = "SELECT * FROM EVENT JOIN USER_EVENT ON EVENT.Event_Id = USER_EVENT.Event_Id ";
  $sql .= "JOIN USER ON USER.Email_Address = USER_EVENT.Email_Address ";
  $sql .= "JOIN EVENT_TYPE ON EVENT.Event_Type_Id = EVENT_TYPE.Event_Type_Id ";
  $sql .= "WHERE EVENT.Event_Id = $eventid AND USER_EVENT.Relationship = 'Owner';";
  $result_set = mysqli_query($database, $sql);

  //check if current user is the owner of the event. If not, redirect.
  if (confirm_not_empty($result_set)) {
    $result = mysqli_fetch_assoc($result_set);
    if (!($_SESSION['Email'] === $result['Email_Address'])) {
      header('Location: displayevent.php?eventid=' . $eventid);
    }
  }
  else {
    echo 'Database query failed';
  }
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Simon Tan">
  <meta name="keywords" content="modify, event, Eventsite, planning">
  <meta name="description" content="Modify event page for Eventsite">  
  <script src="../scripts/modifyevent.js" defer></script>
  <link rel="stylesheet" href="../css/general.css" type="text/css">
  <title>Eventsite - Modify Event</title>
</head>

<body>
  <?php 
    include "../../private/functions/loggedinheader.php";
  ?>
  
  <main class="eventbackground2">
    <div class="formcontainer">
      <button class="backbutton" onclick="history.back()">Go Back</button>
      <h1>Modify Event</h1>
      <form action="validatemodify.php" method="POST">
        <fieldset>
          <legend>Event Details</legend>
          <input type="hidden" name="eventid" value="<?= $eventid ?>">
          <div class="formfield">
            <label for="eventname">Event Name</label>
            <input type="text" name="eventname" id="eventname">
          </div>
          <div class="formfield">
            <label for="eventtype">Event Type</label>
            <select name="eventtype" id="eventtype">
              <?php
                //Populate select options with values from database
                $eventtypequery = "SELECT * FROM EVENT_TYPE;";
                $type_result_set = mysqli_query($database, $eventtypequery);
                if (confirm_not_empty($type_result_set)) {
                  while($type_result = mysqli_fetch_assoc($type_result_set)) {
                    echo '<option value ="' . $type_result["Event_Type_Id"] . '">' . $type_result["Type"] 
                          . '</option>';
                  }
                }
                else {
                  echo 'Database query failed.';
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
        <button type="submit">Modify Event</button>
      </form>
    </div>
  </main>

  <?php
    include "../../private/functions/footer.php"
  ?>

  <script defer>
    const eventName = document.getElementById("eventname");
    const eventType = document.getElementById("eventtype");
    const eventStart = document.getElementById("eventstart");
    const eventEnd = document.getElementById("eventend");
    const visibility = document.getElementById("visibility");
    const address = document.getElementById("address");
    const province = document.getElementById("province");
    const city = document.getElementById("city");
    const postalCode = document.getElementById("postalcode");
    const description = document.getElementById("description");

    //function used to populate fields according to data from the database
    function populateFields() {
      eventName.value = "<?php echo addslashes($result['Event_Name']);?>";
      eventType.value = <?php echo $result['Event_Type_Id'] ?>;
      eventStart.value = "<?php echo $result['Start_Date'] ?>";
      eventEnd.value = "<?php echo $result['End_Date'] ?>";
      visibility.value = "<?php echo $result['Visibility'] ?>";
      address.value = "<?php echo addslashes($result['Address']) ?>";
      province.value = "<?php echo $result['Province'] ?>";
      city.value = "<?php echo addslashes($result['City']) ?>";
      postalCode.value = "<?php echo $result['Postal_Code'] ?>";
      description.value = "<?php echo addslashes($result['Event_Description']) ?>";
    }

    populateFields();
  </script>

</body>