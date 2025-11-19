<?php
require_once("accountFactory.php");
require_once("db.php");
session_start();

if(isset($_SESSION["account"])) {
   $playerAccount = $_SESSION["account"]->id;
   if($_SESSION["account"]->role != "Moderator") {
      try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);
        $result = $db->query("SELECT banned FROM accounts WHERE account_id = '$playerAccount'");
        $row = $result->fetch();
        if($row['banned'] != 1) {
          header("Location: index.php");
          exit();
        }
      }
      
    catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
   }
} else
{
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
      <a href="index.php" class="logo-link">
        <h1 id="header-title">What's the Weather</h1>
      </a>

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
