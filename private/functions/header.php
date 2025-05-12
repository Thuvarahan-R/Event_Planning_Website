<!--
  File Name: header.php
  Created By: Simon Tan (041 161 622), Thuvarahan Ragunathan (041 137 420)
  Date Created: March 30th, 2025
  Description: PHP file that prints html code for the header/nav for pages where the
  user is not logged in.
-->

<?php 
  echo 
    "<header>",
      "<a href='index.php' class='logo'><img src='../images/logo.png' alt='logo for company'></a>",
      "<nav>",
        "<ul>",
          "<li>",
            "<a href='login.php' class='smallbutton'>Login</a>",
          "</li>",
          "<li>",
            "<a href='about.php'>About Us</a>",
          "</li>",
        "</ul>",
      "</nav>",
    "</header>";
?>