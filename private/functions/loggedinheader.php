<!--
  File Name: loggedinheader.php
  Created By: Simon Tan (041 161 622), Thuvarahan Ragunathan (041 137 420)
  Date Created: March 30th, 2025
  Description: PHP file that prints html code for the header/nav for pages where the
  user is logged in.
-->

<?php 
  echo 
    "<header>",
      "<a href='browse.php' class='logo'><img src='../images/logo.png' alt='logo for company'></a>",
      "<nav>",
        "<ul>",
            "<li>",
              "<a href='browse.php'>Home</a>",
            "</li>",
            "<li>",
              "<a href='yourevents.php'>Your Events</a>",
            "</li>",
            "<li class='logoutmenu'>";
  echo  '<button class="logoutbutton">Hello, ' . $_SESSION["First_Name"] . " " 
          . $_SESSION["Last_Name"] . '</button>';
  echo  "<a class='logoutlink' href='logout.php'>Logout</a>",
            "</li>",
      "</nav>",
    "</header>";
?>