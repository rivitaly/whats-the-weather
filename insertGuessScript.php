<?php
require_once("db.php");
require_once("accountFactory.php");
session_start();

if (isset($_SESSION["account"]))
{
try { // data base connection
        $db = new PDO($attr, $db_user, $db_pwd, $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }

    $n_account_id = $_SESSION['account']->id;
    $n_account_display_name = $_SESSION['account']->display_name;

    // Insert correct guess into leaderboards
    $db->exec("INSERT INTO leaderboards (account_id, correct_guess_data, display_name) VALUES ('$n_account_id', NOW(), '$n_account_display_name')");

    $db = null;
}
?>