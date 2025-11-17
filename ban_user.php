<?php
require_once("db.php");
session_start();
$playerAccount = $_POST['account_id'];
// Redirect if not logged in or not a Moderator
if(!isset($_SESSION["account"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "Moderator"){ 
    header("Location: index.php");
    exit();
}
// Redirect if accessed improperly
else if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}
// Redirect if no account id is recieved
else if (!$playerAccount) {
    header("Location: index.php");
    exit();
} else {
    try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $result = $db->query("SELECT banned FROM accounts WHERE account_id = '$playerAccount'");
    // Checking for Database Errors
    if (!$result) {
        $db = null;
        header("Location: index.php");
    // Ban Function
    } else if ($row = $result->fetch()) {
        // Swaps the values between 0 and 1 which represents banned and unbanned, 0 being unbanned and 1 being banned
        $banUnban = $row['banned'] ? 1 : 0;
        // Updates the database
        $db->exec("UPDATE accounts SET banned = '$banUnban' WHERE account_id = '$playerAccount'");
        // Returns you to the Moderator Page
        $db = null;
        header("Location: mod.php");
        exit();
        }
}
// In the event of some unknown error, Redirects you back to the main page
header("Location: index.php")
?>



