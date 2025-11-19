<?php
require_once("accountFactory.php");
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
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }
    $db = null;
}
// In the event of some unknown error, Redirects you back to the main page
header("Location: index.php")
?>


