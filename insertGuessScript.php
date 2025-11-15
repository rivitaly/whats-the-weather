<?php
require_once("db.php");
session_start();

if ($_SESSION["account"]->username != "")
try { // data base connection
        $db = new PDO($attr, $db_user, $db_pwd, $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int) $e->getCode());
    }

    // look for if the username already exists
    $result = $db->query("SELECT username FROM accounts WHERE username='$username'");
    $match = $result->fetch();

?>