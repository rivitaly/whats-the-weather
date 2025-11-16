<?php
session_start();
require_once("accountFactory.php");
require_once("db.php");

if (isset($_SESSION["account_id"])) {
  
  try { // data base connection
    $db = new PDO($attr, $db_user, $db_pwd, $options);
  } catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int) $e->getCode());
  }

  $account = AccountFactory::createAccount($_SESSION["account_id"], $_SESSION["username"],$_SESSION["display_name"], $_SESSION["role"]);
  
  $_SESSION["account"] = $account; //can use this acrosss php files so we can access the account (need to include accountFactory.php when using)

  $welcome_message = ($account->display_name == "") ? "Welcome user\n" : "Welcome back, {$account->display_name}\n";

}
else
{
  $welcome_message = "Welcome user\n";
}

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
  <div id="welcome-user">
    <?php echo "<p class='welcome-message'>{$welcome_message}</p>"?>
  </div>
  <div id="location-display">
    <p id="location-title" class="location-title-hide">City, Country</p>
  </div>
  <div id="main-panel" class="main-layout">
    <div class="ghost-box"></div>
    <div id="planet"></div>
    <div id="leaderboard">
      <p id="leaderboard-title">Leaderboard</p>
      <div id="leaderboard-options">
        <button id="leaderboard-daily">Daily</button>
        <button id="leaderboard-weekly">Weekly</button>
        <button id="leaderboard-monthly">Monthly</button>
      </div>
      <table id="leaderboard-table">
          <tr>
            <th>Username</th>
            <th class="leaderboard-value">10</th>
          </tr>
          <tr>
            <th>Username2</th>
            <th class="leaderboard-value">5</th>
          </tr>
          <tr>
            <th>Username3</th>
            <th class="leaderboard-value">0</th>
          </tr>
      </table>
    </div>
  </div>
  <div id="main-button-container">
    <button id="main-button">Start Guessing</button>
  </div>
  <div id="weather-button-container" style="visibility: hidden">
    <div>
      <button title="Thunderstorm" class="weather-button" id="Thunderstorm"><img src="assets/weather-icons/thunderstorm.png"></button>
      <button title="Drizzle" class="weather-button" id="Drizzle"><img src="assets/weather-icons/drizzle.png"></button>
      <button title="Rain" class="weather-button" id="Rain"><img src="assets/weather-icons/rain.png"></button>
      <button title="Snow" class="weather-button" id="Snow"><img src="assets/weather-icons/snow.png"></button>
    </div>
    <div>
      <button title="Windy" class="weather-button" id="Atmosphere"><img src="assets/weather-icons/atmosphere.png"></button>
      <button title="Clear" class="weather-button" id="Clear"><img src="assets/weather-icons/clear.png"></button>
      <button title="Cloudy" class="weather-button" id="Clouds"><img src="assets/weather-icons/clouds.png"></button>
    </div>
  </div>
  <script type="module" src="js/main.js"></script>
  <script type="module" src="js/render.js"></script>
  </div>
</body>

</html>