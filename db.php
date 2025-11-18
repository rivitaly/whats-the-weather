<?php
	$db_host = getenv('DB_HOST');
	$db_user = getenv('DB_USER');
	$db_pwd = getenv('DB_PASS');
	$db_db = getenv('DB_NAME');

	$charset = 'utf8mb4';
	$attr = "mysql:host=$db_host;dbname=$db_db;charset=$charset";
	$options = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false,
	];
?>