<?php
session_start();
if(!isset($_SESSION['username']))
{
	header("Location:login.php?err=" . urlencode("Please log in to your account."));
	exit();
}
$email = $_SESSION['email'];
$token = $_SESSION['token'];
$message = "Please click on the following link to change your password: http://localhost:8080/camagru/changepw.php?token=$token";
mail($email, 'camagru change password', $message);
header("Location:account.php?err=" . urlencode("Please check your email to change your password."));
exit();
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Change Password</title>
</head>
<body>
</body>
</html>
