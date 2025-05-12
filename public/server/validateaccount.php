<!--
  File Name: validateaccount.php
  Created By: Simon Tan (041 161 622), Thuvarahan Ragunathan (041 137 420)
  Date Created: March 30th, 2025
  Description: PHP page that queries the database to create a new account based
  on information the user entered from createaccount.php
-->

<?php
  require_once "../../private/functions/connection.php";
  $database = db_connect();

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($database, $_POST['email']);
    $fname = mysqli_real_escape_string($database, $_POST['fname']);
    $lname = mysqli_real_escape_string($database, $_POST['lname']);
    $password = mysqli_real_escape_string($database, $_POST['password']);
    
    //query to check if email address entered was already in use
    $emailsql = 'SELECT * FROM USER WHERE Email_Address LIKE "' . $email .'";';
    $email_result_set = mysqli_query($database, $emailsql);
    
    if (confirm_not_empty($email_result_set)) {
      echo 'Email already in use. Please try again.';
    }
    else {
      $insertsql = "INSERT INTO USER VALUES ('$email', '$fname', '$lname', '$password');";
      $result = mysqli_query($database, $insertsql);

      db_disconnect($database);
      if ($result) {
        header("Location: showaccount.php?email=$email");
      }
      else {
        echo "Unable to create account. Please try again.";
      }
    }
  } 
  else {
    header("Location: createaccount.php");
  }
?>