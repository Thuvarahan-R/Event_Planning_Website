<!--
  File Name: validatelogin.php
  Created By: Simon Tan (041 161 622), Thuvarahan Ragunathan (041 137 420)
  Date Created: March 30th, 2025
  Description: PHP page that validates the user's login information and sets the
  session variables.
-->

<?php
  session_start();
  require_once "../../private/functions/connection.php";
  $database = db_connect();

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (isset($_POST["eventid"])) {
      $eventid = $_POST["eventid"];
    }


    $sql = "SELECT * FROM USER WHERE Email_Address = '$email'";
    $result_set = mysqli_query($database, $sql);
    $result = mysqli_fetch_assoc($result_set);

    db_disconnect($database);
    if (confirm_not_empty($result_set)) {
      if($password === $result['Password']) {
        $_SESSION["Email"] = $email;
        $_SESSION["First_Name"] = $result['First_Name'];
        $_SESSION["Last_Name"] = $result['Last_Name'];
        if (isset($eventid)) {
          header('Location: displayevent.php?eventid=' . $eventid);
        }
        else {
          header("Location: browse.php");
        }
      }
      else {
        echo "No matching email and password";
        echo "<a href='login.php'>Please try again</a>";
      }
    }
    else {
      echo "Email not found.";
      echo "<a href='login.php'>Please try again</a>";
    }
  }
  else {
    header("Location: login.php");
  }
?>