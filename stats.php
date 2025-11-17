<?php
require_once("db.php");
session_start();

// Redirect if not signed in
if(!isset($_SESSION["account"])){
    header("Location: index.php");
    exit();
}

$userId = $_SESSION["account_id"];

try {
    $db = new PDO($attr, $db_user, $db_pwd, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch counts using SQL
$stmt = $db->prepare("
    SELECT
        COUNT(*) AS all_time,
        SUM(DATE(correct_guess_data) = CURDATE()) AS daily,
        SUM(DATE(correct_guess_data) >= DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY)) AS weekly,
        SUM(DATE(correct_guess_data) >= DATE_FORMAT(CURDATE(), '%Y-%m-01')) AS monthly
    FROM leaderboards
    WHERE account_id = ?
");
$stmt->execute([$userId]);
$counts = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch all guesses for detailed table
$stmt2 = $db->prepare("
    SELECT correct_guess_data
    FROM leaderboards
    WHERE account_id = ?
    ORDER BY correct_guess_data DESC
");
$stmt2->execute([$userId]);
$guesses = $stmt2->fetchAll(PDO::FETCH_ASSOC);
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
    <h2 id="stats-name-display"><?= $_SESSION["display_name"] ?>'s Stats</h2>

    <table id="stats-table">
        <tr>
            <th>Daily</th>
            <th>Weekly</th>
            <th>Monthly</th>
            <th>All Time</th>
        </tr>
        <tr>
            <td><?= $counts['daily'] ?></td>
            <td><?= $counts['weekly'] ?></td>
            <td><?= $counts['monthly'] ?></td>
            <td><?= $counts['all_time'] ?></td>
        </tr>
    </table>

    <h3>All Correct Guess Dates</h3>
    <table class="user-stats-table">
        <tr>
            <th>#</th>
            <th>Date & Time</th>
        </tr>
        <?php if(empty($guesses)): ?>
            <tr><td colspan="2">No correct guesses yet.</td></tr>
        <?php else: ?>
            <?php foreach($guesses as $i => $row): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= date("Y-m-d H:i", strtotime($row['correct_guess_data'])) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</div>

</body>
</html>