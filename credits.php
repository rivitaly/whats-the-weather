<?php
session_start();
require_once("accountFactory.php");
require_once("db.php");

?>

<!DOCTYPE html>
<html>

<head>
  <title>What's the Weather</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script type="importmap">
            {
                "imports": {
                    "three": "https://cdn.jsdelivr.net/npm/three@v0.180.0/build/three.module.js",
                    "three/addons/": "https://cdn.jsdelivr.net/npm/three@v0.180.0/examples/jsm/"
                }
            }
        </script>
  <link rel="stylesheet" href="css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Audiowide&family=Play:wght@400;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="icon" type="image/png" href="assets/favicon.ico"/>
</head>
<script>
    const USER_LOGGED_IN = <?php echo isset($_SESSION["account"]) ? "true" : "false"; ?>; //used for main.js
</script>
<script type="module" src="js/main.js"></script>
<script type="module" src="js/render.js"></script>

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
            if ($_SESSION["account"]->role == "Moderator"){
              echo '<li><a href="mod.php">Mod Panel</a></li>';
            }
            echo '<li><a href="stats.php">Player Stats</a></li>';
            echo '<li><a href="credits.php">Source Credits</a></li>';
            echo '<li><a href="logout.php">Log Out</a></li>';
          }
          else{
            echo '<li><a href="credits.php">Source Credits</a></li>';
            echo '<li><a href="signin.php">Sign In</a></li>';
            echo '<li><a href="signup.php">Sign Up</a></li>';
          }
        ?>
      </ul>
    </nav>
  </div>
</header>
<p id="mod-panel-header">Credits</p>

<div id="mod-table-container">
    <table id="users-table">
        <tr>
            <th>Item</th>
            <th>Source</th>
        </tr>

        <tr>
            <td>Earth Model</td>
            <td><a href="https://sketchfab.com/3d-models/planeet-aarde-1dbdb56dd730412cb7e23f772b3794e5">Sketchfab Model</a></td>
        </tr>

        <tr>
            <td>Rendering Engine</td>
            <td><a href="https://threejs.org/">Three.js</a></td>
        </tr>

        <tr>
            <td>Weather API</td>
            <td><a href="https://openweathermap.org/">OpenWeatherMap</a></td>
        </tr>

        <tr>
            <td>Weather Icons</td>
            <td><a href="https://www.vecteezy.com/free-vector/weather">Vecteezy (Weather Icons)</a></td>
        </tr>
    </table>
</div>
</body>
</html>