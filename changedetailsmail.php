<?php
session_start();
if(!isset($_SESSION['username']))
{
	header("Location:login.php?err=" . urlencode("Please log in to your account."));
	exit();
}
$email = $_SESSION['email'];
$token = $_SESSION['token'];
$message = "Please click on the following link to change your account details: http://localhost:8080/camagru/changedetails.php?token=$token";
mail($email, 'Camagru Change Details', $message);
header("Location:account.php?err=" . urlencode("Please check your email to change your account details."));
exit();
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Change Account Details</title>
</head>
<body>
</body>
</html>
