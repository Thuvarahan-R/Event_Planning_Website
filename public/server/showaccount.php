<!--
  File Name: showaccount.php
  Created By: Simon Tan (041 161 622), Thuvarahan Ragunathan (041 137 420)
  Date Created: March 30th, 2025
  Description: Page to show new account details after a user has created an account.
-->

<?php
  require_once "../../private/functions/connection.php";
  $database = db_connect();

  if(isset($_GET['email'])) {
    $email = $_GET['email'];
  }
  else {
    header("Location: createaccount.php");
  }
  $sql = "SELECT * FROM USER WHERE Email_Address = '$email'";
  $result_set = mysqli_query($database, $sql);
  $result = mysqli_fetch_assoc($result_set);
  db_disconnect($database);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Simon Tan">
  <meta name="keywords" content="new, account, event, Eventsite">
  <meta name="description" content="Page that displays new account details">
  <link rel="stylesheet" href="../css/general.css" type="text/css">
  <title>Eventsite - Successful Account Creation</title>
</head>

<body>
  <?php include "../../private/functions/header.php"?>
  <main>
    <div class="displayaccountbox">
      <h1 class="middleheader">Account Successfully Created</h1>
      <?php
        if (confirm_not_empty($result_set)) {
          echo '<p>Email: '. $result["Email_Address"]. '</p>';
          echo '<p>Name: ' . $result["First_Name"] . ' ' . $result["Last_Name"] . '</p>';
        }
        else {
          echo 'Database query failed';
        }
      ?>
      <a class="smallbutton" href="login.php">Back to Login</a>
    </div>
  </main>
  <?php include "../../private/functions/footer.php"?>
</body>