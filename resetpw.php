<?php
	include 'config/database.php';
	$token = $_GET['token'];
	if(isset($_POST['submit']))
	{
		if ($_POST['password'] != $_POST['confirm_password'])
		{
			header("Location:register.php?err=" . urlencode("Passwords don't match."));
			exit();
		}
		else if (!preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $_POST['password']))
		{
			header("Location:register.php?err=" . urlencode("Password must contain numbers and letters."));
			exit();
		}
		$password = hash('haval256,4', $_POST['password']);
		try {
			$exec = $pdo->prepare("UPDATE users SET password='$password' where pwtoken='$token'");
			if ($exec->execute())
			{
				header("Location:login.php?err=Your password has been reset! Please log in here.");
				exit();
			}
			else
			{
				header("Location:resetpw.php?err=Account does not exist.");
				exit();			
			}
		}
		catch (PDOException $e)
		{
			echo "Error: ". $e->getMessage(); 
		}
	}
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Reset Password</title>
</head>
<body>
<div>
<?php if(isset($_GET['err'])) {?>
		<div>
			<?php echo $_GET['err']; ?>
		</div>
		<?php } ?>
	<div>
		<p>Enter new password:</p>
			<form method="post" action="resetpw.php">
				<div>
					<label>Password</label>
					<input type="password" name="password" placeholder="Password" required>
				</div>
				<div>
					<label>Confirm password</label>
					<input type="password" name="confirm_password" placeholder="Confirm Password" required>
				</div>
				<div>
					<button type="submit" name="submit">Reset Password</button>
				</div>
			</form>
	</div>
</div>
</body>
</html>
