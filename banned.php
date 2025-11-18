<?php
require_once("db.php");
session_start();

//If not logged in or not Moderator, redirect
if(!isset($_SESSION["account"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "Moderator"){

}

?>

<!DOCTYPE html>
<html>

<head>
  <title>What's the Weather</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <header>
    <div class="header">
      <a href="index.php" class="logo-link">
        <h1 id="header-title">What's the Weather</h1>
      </a>

      <!-- Hamburger Button -->
      <input type="checkbox" id="nav-toggle" class="nav-toggle">
      <label for="nav-toggle" class="hamburger">
        <span></span>
        <span></span>
        <span></span>
      </label>
    </div>
  </header>
  <p id="banned-text">You have been banned.</p>
  <div id="banned-container">
    <a href="logout.php"><button id="main-button">Log Out</button></a>
  </div>
  <script type="module" src="js/main.js"></script>
  <script type="module" src="js/render.js"></script>
</body>

</html>
