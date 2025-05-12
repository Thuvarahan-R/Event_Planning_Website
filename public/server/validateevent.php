<!--
  File Name: validateevent.php
  Created By: Simon Tan (041 161 622), Thuvarahan Ragunathan (041 137 420)
  Date Created: March 30th, 2025
  Description: PHP page that queries the database to create an event
  based on information the user entered in createevent.php
-->

<?php
  session_start();
  require_once "../../private/functions/connection.php";
  $database = db_connect();

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //Get variables from POST method
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
  
    //insert new event information into database
    $sql = 'INSERT INTO EVENT(Event_Name, Event_Description, Event_Type_Id, ' . 
    'Start_Date, End_Date, Visibility, Address, City, Province, Postal_Code) ' . 
    'VALUES ("' . $event_name . '", "' . $description . '", ' . 
    $event_type . ', "' . $start_date . '", "' . $end_date . '", "' .
    $visibility . '", "' . $address . '", "' . $city . '", "' . $province . '", "' . 
    $postal_code . '");';
    $result = mysqli_query($database, $sql);

    $new_event_id = mysqli_insert_id($database);

    //insert current user as owner of the event
    $sql2 = 'INSERT INTO USER_EVENT(Event_Id, Email_Address, Relationship) ';
    $sql2 .= 'VALUES (' . $new_event_id . ', "' . $_SESSION["Email"] .'", ';
    $sql2 .= '"Owner");';

    $result2 = mysqli_query($database, $sql2);

    db_disconnect($database);
    if ($result && $result2) {
      header('Location: displayevent.php?eventid=' . $new_event_id);
    }
    else {
      echo "Unable to create event. Please try again.";
    }
  } 
  else {
    header("Location: createevent.php");
  }
?>