<!--
  File Name: createaccount.php
  Created By: Simon Tan (041 161 622), Thuvarahan Ragunathan (041 137 420)
  Date Created: March 30th, 2025
  Description: The page containing the form users will fill to create an account.
-->

<?php
  require_once "../../private/functions/connection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Simon Tan">
  <meta name="keywords" content="create account, sign-up, Eventsite">
  <meta name="description" content="The create account page for Eventsite">
  <link rel="stylesheet" href="../css/general.css" type="text/css">
  <script src="../scripts/createaccount.js" defer></script>
  <title>Eventsite - Create Account</title>
</head>

<body>
  <?php
    include "../../private/functions/header.php";
  ?>
  <main class="eventbackground1">
    <div class="formcontainer">
    <a class="smallbutton" href="login.php">Back</a>
      <h1>Create an Account</h1>
      <form action="validateaccount.php" method="POST" onsubmit="return validate();">
        <div class="formfield">
          <label for="fname">First Name</label>
          <input type="text" name="fname" id="fname">
        </div>
        <div class="formfield">
          <label for="lname">Last Name</label>
          <input type="text" name="lname" id="lname">
        </div>
        <div class="formfield">
          <label for="email">Email</label>
          <input type="email" name="email" id="email">
        </div>
        <div class="formfield">
          <label for="password">Password</label>
          <input type="password" name="password" id="password">
        </div>
        <div class="formfield">
          <label for="confirmpassword">Confirm Password</label>
          <input type="password" name="confirmpassword" id="confirmpassword">
        </div>
        <button type="submit">Create Account</button>
      </form>
    </div>
  </main>

  <?php
    include "../../private/functions/footer.php"
  ?>
</body>
</html>