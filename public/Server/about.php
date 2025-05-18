<!--
  File Name: about.php
  Created By: Simon Tan (041 161 622), Thuvarahan Ragunathan (041 137 420)
  Date Created: March 30th, 2025
  Description: A page that provides details about the founders of the website.
-->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Simon Tan">
  <meta name="keywords" content="Eventsite, Simon Tan, Thuvarahan Ragunathan">
  <meta name="description" content="About us page for Eventsite.">
  <link rel="stylesheet" href="../css/general.css" type="text/css">
  <title>Eventsite - About Us</title>
</head>

<body>
  <?php
    include "../../private/functions/header.php";
  ?>

  <main class="aboutusbox">
    <section>
      <h1 class="middleheader">About Us</h1>
      <p>
        We are students from Algonquin College. We created this website to learn about
        linking a website's front end to a backend using XAMPP. 
      </p>
    </section>
    <section>
      <h2 class="middleheader">Founders</h2>
      <div class="founderbox">
        <figure>
        <img src="../images/Simon.jpg" alt="Headshot of Simon Tan">
          <figcaption>Simon Tan</figcaption>
        </figure>
        <figure>
          <img src="../images/Thuva.jpg" alt="Headshot of Thuvarahan Ragunathan">
          <figcaption>Thuvarahan Ragunathan</figcaption>
        </figure>
      </div>
    </section>
  </main>

  <?php
    include "../../private/functions/footer.php"
  ?>
</body>
</html>