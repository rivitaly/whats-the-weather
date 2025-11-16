<?php
require_once("db.php");
session_start();

//If not logged in or not Moderator, redirect
if(!isset($_SESSION["account"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "Moderator"){
    header("Location: index.php");
    exit();
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
      <a href="index.php">
        <h1 id="header-title">What's the Weather</h1>
      </a>
      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <?php
            if (isset($_SESSION["account"])){
              echo '<li><a id="logout" href="logout.php">Log Out</a></li>';
            }
          ?>
          <?php
            if (!isset($_SESSION["account"])){
              echo '<li><a href="signin.php">Sign In</a></li>';
              echo '<li><a href="signup.php">Sign Up</a></li>';
            }
          ?>
        </ul>
      </nav>
    </div>
  </header>
  <script type="module" src="js/main.js"></script>
  <script type="module" src="js/render.js"></script>
  </div>
</body>

</html>