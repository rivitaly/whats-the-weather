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
  
  $_SESSION["account"] = $account; //can use this acrosss php files so we can access the account

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
  <script type="importmap">
            {
                "imports": {
                    "three": "https://cdn.jsdelivr.net/npm/three@v0.180.0/build/three.module.js",
                    "three/addons/": "https://cdn.jsdelivr.net/npm/three@v0.180.0/examples/jsm/"
                }
            }
        </script>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <header>
    <div class="header">
      <a href="index.php">
        <h1 id="header-title">What's the Weather</h1>
      </a>
      <nav>
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
  <!--
  <div id="welcome-user">
    <?php echo "<p class='welcome-message'>{$welcome_message}</p>"?>
  </div>-->
  <div id="location-display">
    <p id="location-title">City, Country</p>
  </div>
  <div id="main-panel">
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
  <div id="weather-button-container" style="visibility: visible">
    <div>
      <button class="weather-button" id="Thunderstorm"><img src="assets/weather-icons/thunderstorm.png"></button>
      <button class="weather-button" id="Drizzle"><img src="assets/weather-icons/drizzle.png"></button>
      <button class="weather-button" id="Rain"><img src="assets/weather-icons/rain.png"></button>
      <button class="weather-button" id="Snow"><img src="assets/weather-icons/snow.png"></button>
    </div>
    <div>
      <button class="weather-button" id="Atmosphere"><img src="assets/weather-icons/atmosphere.png"></button>
      <button class="weather-button" id="Clear"><img src="assets/weather-icons/clear.png"></button>
      <button class="weather-button" id="Clouds"><img src="assets/weather-icons/clouds.png"></button>
    </div>
  </div>
  <script type="module" src="js/main.js"></script>
  <script type="module" src="js/render.js"></script>
  </div>
</body>

</html>