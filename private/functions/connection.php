<!--
  File Name: connection.php
  Created By: Simon Tan (041 161 622), Thuvarahan Ragunathan (041 137 420)
  Date Created: March 30th, 2025
  Description: PHP file that contains functions used to connect/disconnect
  from the database and also to print events based on query results.
-->

<?php

require_once "credentials.php";

// Create connection
function db_connect() {
  $connection = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
  confirm_db_connection();
  return $connection;
}

//Function to confirm if DB is connected
function confirm_db_connection() {
  if (mysqli_connect_errno()) {
    $msg = "Database Connection Failed" . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")";
    exit($msg);
  }
}

//Function to disconnect from DB
function db_disconnect($connection) {
  if(isset($connection)){
    mysqli_close($connection);
  }
}

//Function to check if a SELECT SQL query returned any results
function confirm_not_empty($result_set) {
  if(mysqli_num_rows($result_set) > 0) {
    return true;
  }
  else {
    return false;
  }
}

/*
  Function to print events using results from a query. Assumes that the query
  contains field names of Event_Name, Start_Date, End_Date, Type, City,
  Province, and Event_Id. Also assumes that the query starts from the
  EVENT table, so that $results['Event_Id'] returns the Event_Id from 
  the EVENT table.
*/
function printevents($result_set) {
  while ($results = mysqli_fetch_assoc($result_set)) {
    if ($results['Type'] == "Sports") {
      echo "<div class='eventbox sportbackground'>";
    }
    elseif ($results['Type'] == "Conference") {
      echo "<div class='eventbox conferencebackground'>";
    }
    elseif ($results['Type'] == "Celebration/Party") {
      echo "<div class='eventbox partybackground'>";
    }
    else {
      echo "<div class='eventbox'>";
    }
    echo "<h3>" . $results['Event_Name'] . "</h3>";
    echo "<p>" . $results['Start_Date'] . "</p>";
    echo "<p>" . $results['End_Date'] . "</p>";
    echo "<p>" . $results['Type'] . "</p>";
    echo "<p>" . $results['City'] . ", " . $results['Province'] . "</p>";
    echo '<a class="eventboxlink" href="displayevent.php?eventid=' . $results['Event_Id'] . '">View Event</a>';
    echo "</div>";
  }
}

?>