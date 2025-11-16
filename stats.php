<?php
require_once("db.php");
session_start();

// If not signed in, redirect
if(!isset($_SESSION["account"])){
    header("Location: index.php");
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

    <!-- Dropdown Menu -->
    <nav class="nav-menu">
      <ul>
        <li><a href="index.php">Home</a></li>
        <?php
          if (isset($_SESSION["account"])){
            if (isset($_SESSION["role"]) && $_SESSION["role"] === "Moderator"){
              echo '<li><a href="mod.php">Mod Panel</a></li>';
            }
            echo '<li><a href="stats.php">Player Stats</a></li>';
            echo '<li><a href="logout.php">Log Out</a></li>';
          }
          else{
            echo '<li><a href="signin.php">Sign In</a></li>';
            echo '<li><a href="signup.php">Sign Up</a></li>';
          }
        ?>
      </ul>
    </nav>
  </div>
</header>
  <p id="stats-name-display">Here's your stats, <?= $_SESSION["display_name"] ?></p>
  <div id="stats-container">
    <!--Access Display Name-->
    <table id="stats-table">
      <tr>
        <th>Daily</th>
        <th>Weekly</th>
        <th>Monthly</th>
        <th>All Time</th>
      </tr>
      <tr>
        <!--Access User's Score Count-->
        <td>0</td>
        <td>0</td>
        <td>0</td>
        <td>0</td>
      </tr>
    </table>
  </div>
  <script type="module" src="js/main.js"></script>
  <script type="module" src="js/render.js"></script>
  </div>
</body>

</html>