<?php
require_once("db.php");
session_start();

// If not signed in, redirect
if(!isset($_SESSION["account"])){
    header("Location: index.php");
    exit();
}

$userId = $_SESSION["account_id"];

// Connect to DB
try {
    $db = new PDO($attr, $db_user, $db_pwd, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch top scores for user, grouped by period
$stmt = $db->prepare("
    SELECT period, score, created_at
    FROM leaderboards
    WHERE account_id = ?
    ORDER BY created_at DESC
");
$stmt->execute([$userId]);
$scores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Organize scores by period
$userScores = [
    "Daily" => [],
    "Weekly" => [],
    "Monthly" => [],
    "All Time" => []
];

foreach ($scores as $row) {
    $period = ucfirst($row['period']); // Ensure capitalization
    if(array_key_exists($period, $userScores)){
        $userScores[$period][] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Stats - What's the Weather</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
  <div class="header">
    <a href="index.php" class="logo-link">
      <h1 id="header-title">What's the Weather</h1>
    </a>

    <input type="checkbox" id="nav-toggle" class="nav-toggle">
    <label for="nav-toggle" class="hamburger">
      <span></span>
      <span></span>
      <span></span>
    </label>

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
          } else {
            echo '<li><a href="signin.php">Sign In</a></li>';
            echo '<li><a href="signup.php">Sign Up</a></li>';
          }
        ?>
      </ul>
    </nav>
  </div>
</header>

<div id="stats-container">
    <h2 id="stats-name-display"><?= $_SESSION["display_name"] ?>'s Best Scores</h2>

    <?php foreach($userScores as $period => $scoresArr): ?>
      <h3><?= $period ?></h3>
      <table class="user-stats-table">
        <tr>
          <th>Score</th>
          <th>Date</th>
        </tr>
        <?php if(empty($scoresArr)): ?>
          <tr><td colspan="2">No scores yet.</td></tr>
        <?php else: ?>
          <?php foreach($scoresArr as $scoreRow): ?>
            <tr>
              <td><?= htmlspecialchars($scoreRow['score']) ?></td>
              <td><?= date("Y-m-d H:i", strtotime($scoreRow['created_at'])) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </table>
    <?php endforeach; ?>
</div>

</body>
</html>