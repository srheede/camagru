<?php
$DB_USER = 'root';
$DB_PASSWORD = 'punchbuggy';
$DB_SERVER = 'localhost';
$DB_NAME = 'camagru';
  // setup database
try {
    $pdo = new PDO("mysql:host=$DB_SERVER", $DB_USER, $DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE IF NOT EXISTS $DB_NAME";
    $pdo->exec($sql);
    echo "Database created successfully<br>";
    }
catch (PDOException $e)
    {
		die($e->getMessage());
    }

$conn = null;
try
	{
	  $pdo = new PDO("mysql:host=$DB_SERVER;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS `users` (
    `user_id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `username` varchar(50) UNIQUE KEY NOT NULL,
    `password` varchar(255) NOT NULL,
    `email` VARCHAR(100) UNIQUE KEY NOT NULL,
    `token` VARCHAR(100) NOT NULL,
    `pwtoken` VARCHAR(100),
    `status` INT(1) DEFAULT '0' NOT NULL,
    `notify` INT(1) DEFAULT '1' NOT NULL
  ) DEFAULT CHARSET=utf8";
    $gal = "CREATE TABLE IF NOT EXISTS `gallery` (
    `image_id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `date` DATETIME NOT NULL,
    `user_id` INT NOT NULL,
    `image` MEDIUMTEXT NOT NULL,
    `likes` INT DEFAULT '0' NOT NULL
  ) DEFAULT CHARSET=utf8";
    $comments = "CREATE TABLE IF NOT EXISTS `comments` (
        `comment_id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
        `image_id` INT NOT NULL,
        `username` VARCHAR(50) NOT NULL,
        `comment` VARCHAR(300)
      ) DEFAULT CHARSET=utf8";
    $pdo->exec($sql);
    $pdo->exec($gal);
    $pdo->exec($comments);
    echo "Tables created successfully<br>";
}
catch (PDOException $e)
	{
		die($e->getMessage());
	}

?>
