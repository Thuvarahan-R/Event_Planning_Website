<!--
  File Name: login.php
  Created By: Simon Tan (041 161 622), Thuvarahan Ragunathan (041 137 420)
  Date Created: March 30th, 2025
  Description: PHP page that contains the form for users to log in. 
-->

<?php
  session_start();
  require_once "../../private/functions/connection.php";

  //Get an eventid from the URL if the user was redirected to login.php from displayevent.php
  if (isset($_GET["eventid"])) {
    $eventid = $_GET["eventid"];
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Simon Tan">
  <meta name="keywords" content="login, Eventsite, event, planning">
  <meta name="description" content="Login page for Eventsite.">
  <link rel="stylesheet" href="../css/general.css" type="text/css">
  <script src="../scripts/login.js" defer></script>
  <title>Eventsite - Login</title>
</head>

<body>
  <?php
    include "../../private/functions/header.php";
  ?>
  <main class="eventbackground1">
    <div class="formcontainer">
      <a class="smallbutton" href="index.php">Back</a>
      <h1>Login</h1>
      <form action="validatelogin.php" method="POST" onsubmit="return validateLogin();">
        <div class="formfield">
          <label for="email">Email</label>
          <input type="email" name="email" id="email">
        </div>
        <div class="formfield">
          <label for="password">Password</label>
          <input type="password" name="password" id="password">
        </div>
        <?php 
          //add hidden form field containing eventid if it was set
          if (isset($eventid)) {
            echo '<input type="hidden" name="eventid" id="eventid" value="' . $eventid . '">';
          } 
        ?>
        <button type="submit">Login</button>
      </form>
      <hr>
      <a href="createaccount.php" class="createlink">Create an Account</a>
    </div>
  </main>

  <?php
    include "../../private/functions/footer.php"
  ?>
</body>
</html>