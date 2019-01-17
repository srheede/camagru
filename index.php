<?php
session_start();
if(isset($_SESSION['username']))
{
	header("Location:account.php");
	exit();
}
include 'config/database.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Camagru</title>
</head>
<body>
<p><a href="register.php">Register</a></p>
<p><a href="login.php">Login</a></p>

</body>
</html>
