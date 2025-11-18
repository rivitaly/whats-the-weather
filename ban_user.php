<?php
require_once("db.php");
session_start();

// Redirect if not logged in or not a Moderator
if(!isset($_SESSION["account"]) || $_SESSION["account"]->role != "Moderator"){ 
    header("Location: index.php");
    exit();
}
// Redirect if accessed improperly
else if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}
// Redirect if no account id is recieved
else if (!$_POST['account_id']) {
    header("Location: index.php");
    exit();
} else {
    try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);
        $playerAccount = $_POST['account_id'];
        $_SESSION["account"]->ban($db, $playerAccount); //Moderator check earlier allows us to call ban()
        /*
        $result = $db->query("SELECT banned from accounts WHERE account_id = '$playerAccount'");
        // Checking for Database Errors
        if (!$result) {
            $db = null;
            header("Location: index.php");
            // Ban Function
        } else if ($row = $result->fetch()) {
            // Swaps the values between 0 and 1 which represents banned and unbanned, 0 being unbanned and 1 being banned
            $banUnban = $row['banned'] ? '0' : '1';
            // Updates the database
            $db->exec("UPDATE accounts SET banned = '$banUnban' WHERE account_id = '$playerAccount'");
            // Returns you to the Moderator Page
            header("Location: mod.php");
            exit();
        }
        */
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $db = null;
}

// In the event of some unknown error, Redirects you back to the main page
header("Location: index.php")
?>

