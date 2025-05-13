<!--
  File Name: yourevents.php
  Created By: Simon Tan (041 161 622), Thuvarahan Ragunathan (041 137 420)
  Date Created: March 30th, 2025
  Description: Page that displays the events the current user has created
  and the events they are registered to. Also links users to the createevent
  page.
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
  <meta name="keywords" content="your events, hosting, Eventsite">
  <meta name="description" content="Page that displays the user's created/registered events">
  <link rel="stylesheet" href="../css/general.css" type="text/css">
  <title>Event Planning Website - Your Events</title>
</head>

<body>
  <?php 
    include "../../private/functions/loggedinheader.php";
  ?>
  
  <main>
    <h1 class="middleheader">Dashboard</h1>
    <a href="createevent.php" id="createnewevent">Create New Event</a>
    <section class="grideventslide">
      <h2 class="middleheader">Your Events</h2>
      <div class="grideventcontainer">
        <?php
          //query to print the events that the user has created
          $sql = "SELECT * ";
          $sql .= "FROM EVENT JOIN USER_EVENT ON EVENT.Event_Id = USER_EVENT.Event_Id ";
          $sql .= "JOIN EVENT_TYPE ON EVENT.Event_Type_Id = EVENT_TYPE.Event_Type_Id ";
          $sql .= 'WHERE Email_Address = "' . $_SESSION['Email'] . '" AND Relationship = "Owner" ';
          $sql .= "AND End_Date > CURRENT_TIMESTAMP;";
          $result_set = mysqli_query($database, $sql);
          if (confirm_not_empty($result_set)) {
            printevents($result_set);
          }
          else {
            echo "No results found";
          }
        ?>
      </div>
    </section>
    <div class='grideventslide'>
      <h2 class="middleheader">Your Registered Events</h2>
      <div class="grideventcontainer">
        <?php
          //query to print the events that the user is registered to
          $registered_sql = "SELECT * ";
          $registered_sql .= "FROM EVENT JOIN USER_EVENT ON EVENT.Event_Id = USER_EVENT.Event_Id ";
          $registered_sql .= "JOIN EVENT_TYPE ON EVENT.Event_Type_Id = EVENT_TYPE.Event_Type_Id ";
          $registered_sql .= 'WHERE Email_Address = "' . $_SESSION['Email']; 
          $registered_sql .= '" AND Relationship = "Participant" ';
          $registered_sql .= "AND End_Date > CURRENT_TIMESTAMP;";
          $registered_result_set = mysqli_query($database, $registered_sql);
          db_disconnect($database);
          if (confirm_not_empty($registered_result_set)) {
            printevents($registered_result_set);
          }
          else {
            echo "No results found";
          }
        ?>
      </div>
    </div>
  </main>

  <?php
    include "../../private/functions/footer.php"
  ?>
</body>