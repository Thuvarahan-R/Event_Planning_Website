<!--
  File Name: deleteevent.php
  Created By: Simon Tan (041 161 622), Thuvarahan Ragunathan (041 137 420)
  Date Created: March 30th, 2025
  Description: PHP page that processes a user's request to delete an event that they own.
-->

<?php
  session_start();
  require_once "../../private/functions/connection.php";
  $database = db_connect();

  //Check if user is logged in
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
  if (confirm_not_empty($result_set)) {
    $result = mysqli_fetch_assoc($result_set);
    //Check if user is the owner of the event. If not, redirect
    if (!($_SESSION['Email'] === $result['Email_Address'])) {
      header('Location: displayevent.php?eventid=' . $eventid);
    }
    else {
      //Delete rows from user_event table
      $sql = 'DELETE FROM USER_EVENT WHERE Event_Id = ' . $eventid . ';';
      $result = mysqli_query($database, $sql);

      //Delete row from event table
      $sql2 = 'DELETE FROM EVENT WHERE Event_Id = ' . $eventid . ';';
      $result2 = mysqli_query($database, $sql2);

      db_disconnect($database);
      if ($result && $result2) {
        header("Location:yourevents.php");
      }
      else {
        echo "Database query failed. Please try again.";
      }
    }
  }
  else {
    echo "Database query failed. Please try again.";
  }
?>