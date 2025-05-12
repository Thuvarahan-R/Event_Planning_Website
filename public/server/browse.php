<!--
  File Name: browse.php
  Created By: Simon Tan (041 161 622), Thuvarahan Ragunathan (041 137 420)
  Date Created: March 30th, 2025
  Description: The main page that users will interact with when they log in.
  The user will be able to search and filter through events here.
-->

<?php
  session_start();
  require_once "../../private/functions/connection.php";
  $database = db_connect();

  //check if user is logged in
  if(!isset($_SESSION['Email'])) {
    header("Location: login.php");
  }

  //get the search/filter/sort information from the url
  if (isset($_GET["searchbar"]) && !empty($_GET["searchbar"])) {
    $searchtext = $_GET["searchbar"];
  }

  if (isset($_GET["eventtype"]) && $_GET["eventtype"] != "All") {
    $eventtype = $_GET["eventtype"];
  }

  if (isset($_GET["province"]) && ($_GET["province"] != "All")) {
    $province = $_GET["province"];
  }

  if (isset($_GET["date"]) && !empty($_GET["date"])) {
    $date = $_GET["date"];
  }

  if (isset($_GET["sortoption"])) {
    $sortoption = $_GET["sortoption"];
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Simon Tan">
  <meta name="keywords" content="event, planning, search">
  <meta name="description" content="Main page where users can browse events on Eventsite">
  <link rel="stylesheet" href="../css/general.css" type="text/css">
  <title>Eventsite - Home</title>
</head>

<body>
  <?php 
    include "../../private/functions/loggedinheader.php";
  ?>
  
  <main>
    <h1 class="middleheader">Browse Events</h1>
    <section class="eventslide">
      <div class="eventcontainer">
        <?php
          // Query that is constructed based on searchbar value and filters.
          $sql = "SELECT * ";
          $sql .="FROM EVENT JOIN EVENT_TYPE ON EVENT.Event_Type_Id = EVENT_TYPE.Event_Type_Id ";
          $sql .="WHERE Visibility = 'PUBLIC' ";
          if (isset($searchtext)){
            $sql .= 'AND Event_Name LIKE \'%' . $searchtext . '%\' ';
          }
          if (isset($eventtype)){
            $sql .= 'AND Type = "' . $eventtype . '" ';
          }
          if (isset($province)){
            $sql .= 'AND Province = "' . $province . '" ';
          }
          if (isset($date)){
            $sql .= 'AND DATE(Start_Date) = "' . $date . '" ';
          }
          $sql .= "AND Start_Date > CURRENT_TIMESTAMP ";
          if (isset($sortoption)) {
            if ($sortoption == "nameasc") {
              $sql .= "ORDER BY Event_Name ASC";
            }
            else if ($sortoption == "namedesc") {
              $sql .= "ORDER BY Event_Name DESC";
            }
            else if ($sortoption == "dateasc") {
              $sql .= "ORDER BY Start_Date ASC";
            }
            else if ($sortoption == "datedesc") {
              $sql .= "ORDER BY Start_Date DESC";
            }
          }
          $result_set = mysqli_query($database, $sql);
          /* 
            Prints the events if the database returned at least one
            result from the query. 
          */ 
          if (confirm_not_empty($result_set)) {
            printevents($result_set);
          }
          else {
            echo "No results found";
          }
        ?>
      </div>
      <aside>
        <!-- searchbox form that will send search values back to the same page in the url -->
        <form action="browse.php" method="GET" class="searchbox">
          <div class="bigsearchitem">
            <label for="searchbar">Search by Event Name</label>
            <input type="text" name="searchbar" id="searchbar" placeholder="Type here...">
          </div>
          <div class="smallsearchitem">
          <label for="eventtype">Filter by Event Type</label>
            <select name="eventtype" id="eventtype">
              <option selected>All</option>
              <!-- populate the select options with event types from the database -->
              <?php 
                $eventtypequery = "SELECT * FROM EVENT_TYPE;";
                $type_result_set = mysqli_query($database, $eventtypequery);
                if (confirm_not_empty($type_result_set)) {
                  while($type_result = mysqli_fetch_assoc($type_result_set)) {
                    echo '<option value ="' . $type_result["Type"] . '">' . $type_result["Type"] 
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
          <div class="smallsearchitem">
            <label for="province">Filter by Location (Province)</label>
            <select name="province" id="province">
              <option selected>All</option>
              <option value="AB">Alberta</option>
              <option value="BC">British Colombia</option>
              <option value="MB">Manitoba</option>
              <option value="NB">New Brunswick</option>
              <option value="NL">Newfoundland and Labrador</option>
              <option value="NS">Nova Scotia</option>
              <option value="ON">Ontario</option>
              <option value="PE">Prince Edward Island</option>
              <option value="QC">Quebec</option>
              <option value="SK">Saskatchewan</option>
            </select>
          </div>
          <div class="smallsearchitem">
            <label for="date">Filter by Date</label>
            <input type="date" name="date" id="date">
          </div>
          <div class="smallsearchitem">
            <label>Sort by</label>
            <select name="sortoption" id="sortoption">
              <option value="none" selected>No option selected</option>
              <option value="nameasc">Event Name (a-z)</option>
              <option value="namedesc">Event Name (z-a)</option>
              <option value="dateasc">Date (soonest - latest)</option>
              <option value="datedesc">Date (latest - soonest)</option>
            </select>
          </div>
          <div class="bigsearchitem">
            <button type="submit" class="searchbutton">Search</button>
            <button type="reset" class="searchbutton">Clear Filters</button>
            <a href="browse.php" class="eventboxlink">Clear Results</a>
          </div>
        </form>
      </aside>
    </section>
  </main>

<?php
  include "../../private/functions/footer.php"
?>

<?php
  //populate search fields with previous search options when page is reloaded
  if (isset($_GET["searchbar"])) {
    echo '<script defer>',
        'const searchbar = document.getElementById("searchbar");';
    echo 'searchbar.value = "' . $_GET["searchbar"] . '";';
    
    echo 'const eventtype = document.getElementById("eventtype");';
    echo 'eventtype.value = "' . $_GET["eventtype"] . '";';
      
    echo 'const province = document.getElementById("province");';
    echo 'province.value = "' . $_GET["province"] . '";';
      
    echo 'const date = document.getElementById("date");';
    echo 'date.value = "' . $_GET["date"] . '";';
      
    echo 'const sortoption = document.getElementById("sortoption");';
    echo 'sortoption.value = "' . $_GET["sortoption"] . '";';
    echo '</script>';
  }
?>

</body>