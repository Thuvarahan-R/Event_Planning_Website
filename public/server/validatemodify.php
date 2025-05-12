<!--
  File Name: validatemodify.php
  Created By: Simon Tan (041 161 622), Thuvarahan Ragunathan (041 137 420)
  Date Created: March 30th, 2025
  Description: PHP page that queries the database to modify an event
  based on information the user entered in modifyevent.php
-->

<?php
  session_start();
  require_once "../../private/functions/connection.php";
  $database = db_connect();

  if(!isset($_SESSION['Email'])) {
    header("Location: login.php");
  }

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //get updated event information from the modifyevent.php page
    $event_id = $_POST['eventid'];
    $event_name = mysqli_real_escape_string($database, $_POST['eventname']);
    $event_type = $_POST['eventtype'];
    $start_date = $_POST['eventstart'];
    $end_date = $_POST['eventend'];
    $visibility = $_POST['visibility'];
    $address = mysqli_real_escape_string($database, $_POST['address']);
    $province = $_POST['province'];
    $city = mysqli_real_escape_string($database, $_POST['city']);
    $postal_code = $_POST['postalcode'];
    $description = mysqli_real_escape_string($database, $_POST['description']);
  
    //Query the database to update the event information
    $sql = 'UPDATE EVENT SET Event_Name = "' . $event_name . '", ';
    $sql .= 'Event_Type_Id = ' . $event_type . ', ';
    $sql .= 'Start_Date = "' . $start_date . '", End_Date = "' . $end_date . '", Visibility = "';
    $sql .= $visibility . '", Address ="' . $address . '", Province = "';
    $sql .= $province . '", City ="' . $city . '", Postal_Code = "' . $postal_code; 
    $sql .='", Event_Description = "' . $description . '" WHERE Event_Id = ' . $event_id . ';';
    $result = mysqli_query($database, $sql);

    db_disconnect($database);
    if ($result) {
      header('Location: displayevent.php?eventid=' . $event_id);
    }
    else {
      echo "Unable to modify event. Please try again.";
    }
  } 
  else {
    header('Location: displayevent.php?eventid=' . $event_id);
  }
?>