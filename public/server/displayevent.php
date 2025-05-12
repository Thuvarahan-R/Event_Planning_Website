<!--
  File Name: displayevent.php
  Created By: Simon Tan (041 161 622), Thuvarahan Ragunathan (041 137 420)
  Date Created: March 30th, 2025
  Description: Page used to display detailed event information to a user. The page
  will provide different information/options depending on whether the user is logged
  in or if they are the owner of the event.
-->

<?php
  session_start();
  require_once "../../private/functions/connection.php";
  $database = db_connect();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Simon Tan">
  <meta name="keywords" content="event, display, details, Eventsite">
  <meta name="description" content="Page that displays detailed event information">
  <link rel="stylesheet" href="../css/general.css" type="text/css">
  <script src="../scripts/displayevent.js" defer></script>
  <title>Eventsite - Display Event</title>
</head>

<body>
  <?php 
    //Check if user is logged in, and load appropriate header.
    if(isset($_SESSION["Email"])) {
      include "../../private/functions/loggedinheader.php"; 
    }
    else {
      include "../../private/functions/header.php";
    }
  ?>

  <main class="displayeventbox">
    <?php 
      //Back button will link to different pages depending on if the user is logged in.
      if(isset($_SESSION["Email"])) {
        echo '<a class="smallbutton" href="browse.php">Back to Home</a>';
      }
      else {
        echo '<button class="backbutton" onclick="history.back()">Back</button>';
      }
      $eventid = $_GET['eventid'];
      //Query to get general event information and owner
      $sql = "SELECT * FROM EVENT JOIN USER_EVENT ON EVENT.Event_Id = USER_EVENT.Event_Id ";
      $sql .= "JOIN USER ON USER.Email_Address = USER_EVENT.Email_Address ";
      $sql .= "JOIN EVENT_TYPE ON EVENT.Event_Type_Id = EVENT_TYPE.Event_Type_Id ";
      $sql .= "WHERE EVENT.Event_Id = $eventid AND USER_EVENT.Relationship = 'Owner';";
      $result_set = mysqli_query($database, $sql);

      //Query to get relationship between the current user and the event
      if (isset($_SESSION["Email"])) {
        $relationshipsql = "SELECT * FROM EVENT JOIN USER_EVENT ON EVENT.Event_Id = ";
        $relationshipsql .= "USER_EVENT.Event_Id ";
        $relationshipsql .= "WHERE EVENT.Event_Id = $eventid AND ";
        $relationshipsql .= 'USER_EVENT.Email_Address = "' . $_SESSION['Email'] . '";';
        $relationship_result_set = mysqli_query($database, $relationshipsql);
        $relationship_result = mysqli_fetch_assoc($relationship_result_set);
      }
      //Query to get the number of people registered to the event
      $countsql = "SELECT COUNT(*) AS Attending ";
      $countsql .= "FROM EVENT JOIN USER_EVENT ON EVENT.Event_Id = USER_EVENT.Event_Id ";
      $countsql .= "WHERE Relationship = 'Participant' AND ";
      $countsql .= 'EVENT.Event_Id = ' . $eventid . ';';
      $count_result_set = mysqli_query($database, $countsql);
      $attending = mysqli_num_rows($count_result_set);

      
      //Display the event information on the page
      if (confirm_not_empty($result_set)) {
        $result = mysqli_fetch_assoc($result_set);
        echo '<h1>' . $result['Event_Name'] . '</h1>';
        echo '<section>';
        echo '<h2>Description</h2>';
        echo '<p>' . $result['Event_Description'] . '</p>';
        echo '<p>Type of Event: ' . $result['Type'] . '</p>';
        echo '<p>Number of Attendees: ' . $attending . '</p>';
        echo '</section>';
        echo '<section>';
        echo '<h2>Location</h2>';
        echo '<p>' . $result['Address'] . ', ' .$result['City'] . ', ' 
                  . $result['Province'] . '</p>';
        echo '<p>Start Date: ' . $result['Start_Date'] . '</p>';
        echo '<p>End Date: ' . $result['End_Date'] . '</p>';
        echo '</section>';
      }
      else {
        echo 'No event information found.';
      }
      //Convert the end date value from the query into a php date object
      $End_Date = strtotime($result['End_Date']);
      //Get the current time of the server
      $Current_Time = $_SERVER['REQUEST_TIME'];
      
      //If user is not logged in, display log in to register link
      if (!isset($_SESSION["Email"]) && $End_Date > $Current_Time) {
        echo '<a class="smallbutton" href="login.php?eventid=' 
              . $eventid . '">Log in to Register for this Event</a>';
      }
      //else if user is logged in and there is no "participant" row found, display register link
      elseif (!confirm_not_empty($relationship_result_set) && $End_Date > $Current_Time) {
        echo '<a class="smallbutton" href="validateregister.php?eventid=' 
              . $eventid . '">Register for this Event</a>';
      }
      //else if the user is the owner, display guest list and modify/delete event link
      elseif ($relationship_result['Relationship'] === "Owner" && $End_Date > $Current_Time) {

        echo "<p>To invite people to your event, copy and send the link in your browser's URL!</p>";
        echo '<table>',
              '<tr>',
                '<th colspan="2">Guest List</th>',
              '</tr>',
              '<tr>',
                '<th>Email</th>',
                '<th>Name</th>',
              '</tr>';

        //Query to get guest list 
        $guestsql = 'SELECT User_Event.Email_Address, CONCAT(First_Name, " ", Last_Name) AS Name ';
        $guestsql .= 'FROM User_Event JOIN User ON User_Event.Email_Address = User.Email_Address ';
        $guestsql .= 'WHERE User_Event.Event_Id = ' . $eventid;
        $guestsql .= ' AND Relationship = "Participant";';
        $guest_set = mysqli_query($database, $guestsql);
        //Print guest list in table form if anyone is registered.
        if (confirm_not_empty($guest_set)) {
          while ($guest = mysqli_fetch_assoc($guest_set)) {
            echo '<tr>';
            echo '<td>' . $guest["Email_Address"] . '</td>';
            echo '<td>' . $guest["Name"] . '</td>';
            echo '</tr>';
          }
        }
        else {
          echo '<tr>';
          echo '<td colspan="2">No one has registered for this event yet</td>';
          echo '</tr>';
        }
        echo '</table>';
        echo '<div>';
        echo '<a class="smallbutton" href="modifyevent.php?eventid=' . $eventid . '">Modify Event</a>';
        echo '<a class="smallbutton" id="deletebutton" href="deleteevent.php?eventid=' 
                  . $eventid . '">Delete Event</a>';
        echo '</div>';

      }
      //Else if they are already registered to the event, display cancel registration link
      elseif ($relationship_result['Relationship'] === "Participant" && $End_Date > $Current_Time) {
        echo '<a class="smallbutton" id="deletebutton" href="validateregister.php?eventid=' 
                . $eventid . '">Cancel Registration</a>';
      }
      else {
        echo "<p>This is an old event</p>";
      }
      db_disconnect($database);
    ?>
  </main>
  <?php
    include "../../private/functions/footer.php";
  ?>
</body>