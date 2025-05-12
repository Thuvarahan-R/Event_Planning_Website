<!--
  File Name: logout.php
  Created By: Simon Tan (041 161 622), Thuvarahan Ragunathan (041 137 420)
  Date Created: March 30th, 2025
  Description: PHP page that logs user out of the website by destroying
  their current session and redirects them back to index.php.
-->

<?php
  session_start();

  if(isset($_SESSION['Email'])) {
    session_destroy();
    header("Location: index.php");
  }
  else {
    header("Location: index.php");
  }
?>