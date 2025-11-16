<?php
require_once("db.php");
session_start();

if (isset($_SESSION["account"]))
{
try { // data base connection
        $db = new PDO($attr, $db_user, $db_pwd, $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }

    $n_account_id = $_SESSION['account']->id;
    $n_account_username = $_SESSION['account']->username;

    // Insert correct guess into leaderboards
    $db->exec("INSERT INTO leaderboards (account_id, correct_guess_data, username) VALUES ('$n_account_id', NOW(), '$n_account_username')");

    $db = null;
}
?>