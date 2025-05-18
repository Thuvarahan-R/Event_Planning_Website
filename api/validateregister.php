<!--
  File Name: validateregister.php
  Created By: Simon Tan (041 161 622), Thuvarahan Ragunathan (041 137 420)
  Date Created: March 30th, 2025
  Description: PHP page  queries the database to register/unregister a user from an event.
  When redirected from displayevent.php, this page will register the user as a participant if
  they have no existing relationship with the event. If they are already a participant, redirecting
  the user to this page will unregister them from the event.
-->

<?php
  session_start();
  require_once "../../private/functions/connection.php";
  $database = db_connect();

  if(!isset($_SESSION["Email"])) {
    header("Location: login.php");
  }
  else {
    $eventid = $_GET["eventid"];

    //Query to check if the user is registered as a participant to the event 
    $sql = 'SELECT * FROM USER_EVENT WHERE Event_Id = ' . $eventid . ' AND Email_Address = "';
    $sql .= $_SESSION["Email"] . '";';
    $result_set = mysqli_query($database, $sql);
    $result = mysqli_fetch_assoc($result_set);

    //If user does not have a relationship with the event, register them to the event
    if(!confirm_not_empty($result_set)) {
      $insertquery = 'INSERT INTO USER_EVENT(Event_Id, Email_Address, Relationship) VALUES ';
      $insertquery .= '( ' . $eventid . ', "' . $_SESSION["Email"] . '", "Participant");';
      $insertresult = mysqli_query($database, $insertquery);
    }
    //If user is currently a participant, unregister them from the event.
    elseif ($result["Relationship"] == "Participant") {
      $deletequery = 'DELETE FROM USER_EVENT WHERE Event_Id = ' . $eventid . ' AND ';
      $deletequery .= 'Email_Address = "' . $_SESSION["Email"] . '";';
      $deleteresult = mysqli_query($database, $deletequery);
    }

    db_disconnect($database);
    if ($insertresult || $deleteresult) {
      header('Location: displayevent.php?eventid=' . $eventid);
    }
    else {
      echo "Unable to register/unregister from event. Please try again";
    }
  }
?>