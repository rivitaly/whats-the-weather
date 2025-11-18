<?php
require_once("db.php");
require_once("accountFactory.php");

session_start();

// Redirect if not logged in or not a Moderator
if(!isset($_SESSION["account"]) || $_SESSION["account"]->role != "Moderator") {
    header("Location: index.php");
    exit();
}

try {
    $db = new PDO($attr, $db_user, $db_pwd, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
// Fetch all users: regular users first, then mods
$stmt = $db->query("
    SELECT account_id, username, display_name, role, banned 
    FROM accounts 
    ORDER BY 
        CASE WHEN role='Moderator' THEN 1 ELSE 0 END ASC, 
        username ASC
");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mod Panel - What's the Weather</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mod.css">
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
                <li><a href="mod.php">Mod Panel</a></li>
                <li><a href="stats.php">Player Stats</a></li>
                <li><a href="credits.php">Source Credits</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </nav>
    </div>
</header>

<p id="mod-panel-header">User Management</p>

<div id="mod-table-container">
    <table id="users-table">
        <tr>
            <th>Username</th>
            <th>Display Name</th>
            <th>Role</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['display_name']) ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
                <td><?= $user['banned'] ? 'Banned' : 'Active' ?></td>
                <td>
                    <?php if($user['role'] === 'Moderator'): ?>
                        <button disabled>Mod</button>
                    <?php else: ?>
                        <form method="post" action="ban_user.php" style="margin:0;">
                            <input type="hidden" name="account_id" value="<?= $user['account_id'] ?>">
                            <input type="hidden" name="action" value="<?= $user['banned'] ? 'unban' : 'ban' ?>">
                            <button type="submit"><?= $user['banned'] ? 'Unban' : 'Ban' ?></button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>
