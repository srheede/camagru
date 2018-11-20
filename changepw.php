<?php
session_start();
if(!isset($_SESSION['username']))
{
	header("Location:login.php?err=" . urlencode("Please log in to your account."));
	exit();
}
include 'config/database.php';
if(isset($_GET['token']))
{
	$token = $_GET['token'];
	if(isset($_POST['submit']))
	{
		if ($_POST['password'] != $_POST['confirm_password'])
		{
			header("Location:changepw.php?err=" . urlencode("Passwords don't match."). "&token=" . urlencode($token));
			exit();
		}
		else if (!preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $_POST['password']))
		{
			header("Location:changepw.php?err=" . urlencode("Password must contain numbers and letters."). "&token=" . urlencode($token));
			exit();
		}
		$password = hash('haval256,4', $_POST['password']);
		$query = "update users set password='$password' where token='$token'";
		if($pdo->query($query))
		{
			header("Location:account.php?err=Your password has been changed!");
			exit();
		}
	}
}
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Change Password</title>
</head>
<body>
<div>
	<div>
		<p>Please enter your new password:</p>
		<?php if(isset($_GET['err'])) {?>
		<div>
			<?php echo $_GET['err']; ?>
		</div>
		<?php } ?>
			<form method="post">
				<div>
					<label>Password</label>
					<input type="password" name="password" placeholder="Password" required>
				</div>
				<div>
					<label>Confirm password</label>
					<input type="password" name="confirm_password" placeholder="Confirm Password" required>
				</div>
				<div>
					<button type="submit" name="submit">Save New Password</button>
				</div>
			</form>
			<p>Don't want to change your password? <a href="account.php">Return to account.</a></p>
	</div>
</div>
</body>
</html>
