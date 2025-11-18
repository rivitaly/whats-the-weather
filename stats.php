<?php
require_once("accountFactory.php");
require_once("db.php");
session_start();

// Redirect if not signed in
if(!isset($_SESSION["account"])){
    header("Location: index.php");
    exit();
}
else
{   
    try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);
        $userId = $_SESSION['account']->id;
        $result = $db->query("SELECT banned from accounts WHERE account_id = '$userId'");
        // Checking for Database Errors
        if ($result) {
            $row = $result->fetch();
            if ($row['banned'] == 1)
            {
                header("Location: banned.php");
                exit();
            }
        }
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
}

// Fetch aggregated counts
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

// Fetch all guesses
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Stats - What's the Weather</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/stats.css">
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
                        if ($_SESSION["account"]->role === "Moderator"){
                            echo '<li><a href="mod.php">Mod Panel</a></li>';
                        }
                        echo '<li><a href="stats.php">Player Stats</a></li>';
                        echo '<li><a href="credits.php">Source Credits</a></li>';
                        echo '<li><a href="logout.php">Log Out</a></li>';
                    } else {
                        echo '<li><a href="credits.php">Source Credits</a></li>';
                        echo '<li><a href="signin.php">Sign In</a></li>';
                        echo '<li><a href="signup.php">Sign Up</a></li>';
                    }
                ?>
            </ul>
        </nav>
    </div>
</header>

<p id="player-stats-header"><?= $_SESSION['account']->display_name ?> Stats :</p>

<div id="stats-tables-container">
    <!-- Left Summary Table -->
    <table id="summary-table">
        <tr>
            <th>Period</th>
            <th>Correct Guesses</th>
        </tr>
        <tr><td>Daily</td><td><?= $counts['daily'] ?></td></tr>
        <tr><td>Weekly (Starts on Monday)</td><td><?= $counts['weekly'] ?></td></tr>
        <tr><td>Monthly (Starts on 1st)</td><td><?= $counts['monthly'] ?></td></tr>
        <tr><td>All Time</td><td><?= $counts['all_time'] ?></td></tr>
    </table>

    <!-- Right Detailed Table -->
    <table id="guesses-table">
        <tr>
            <th># of Correct Guesses</th>
            <th>Date & Time</th>
        </tr>
        <?php if(empty($guesses)): ?>
            <tr><td colspan="2">No correct guesses yet.</td></tr>
        <?php else: ?>
            <?php foreach($guesses as $i => $row): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= date("h:ia, d/m/Y", strtotime($row['correct_guess_data'])) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
