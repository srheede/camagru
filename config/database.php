<?php
	$DB_DSN = 'mysql:host=localhost;dbname=camagru';
	$DB_DSN_LITE = 'mysql:host=localhost';
	$DB_USER = 'root';
	$DB_PASSWORD = 'punchbuggy';
	
	// create PDO instance
	$pdo = new PDO($DB_DSN_LITE, $DB_USER, $DB_PASSWORD);
	//$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	var_dump($pdo);
?>
