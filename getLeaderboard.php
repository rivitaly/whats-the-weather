<?php
header('Content-Type: application/json');

  try { // data base connection
    $db = new PDO($attr, $db_user, $db_pwd, $options);
  } catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int) $e->getCode());
  }

// Get the type (daily, weekly, monthly)
$type = $_GET['type'] ?? 'daily';

// Determine the time range
$timeCondition = "";
switch ($type) {
    case 'daily':
        $timeCondition = "WHERE correct_guess_data >= CURDATE()";
        break;
    case 'weekly':
        $timeCondition = "WHERE correct_guess_data >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
        break;
    case 'monthly':
        $timeCondition = "WHERE correct_guess_data >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
        break;
}

// Fetch top players (example: count number of correct guesses per player)
$sql = "
    SELECT display_name, COUNT(*) as score
    FROM leaderboards
    $timeCondition
    GROUP BY display_name
    ORDER BY score DESC
    LIMIT 10
";

$result = $db->query($sql);
$leaderboard = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $leaderboard[] = $row;
    }
}

echo json_encode($leaderboard);
$mysqli->close();
?>