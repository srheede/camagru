<?php
	include 'config/database.php';
	if(isset($_POST['submit']))
	{
		if(isset($_GET['token']) && $_GET['token'] != "")
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
			$pwtoken = $_GET['token'];
			$new = hash('haval256,4', $_POST['password']);
			try 
			{
				$check = "select * from users where pwtoken='$pwtoken'";
				$result_check = $pdo->query($check);
				if ($result_check->rowCount() > 0)
				{
					$exec = $pdo->prepare("UPDATE users SET password='$new' where pwtoken='$pwtoken'");
					$exec->execute();
					header("Location:login.php?err=" . urlencode("Your password has been reset! Please log in here."));
					exit();
				}
				else
				{
					header("Location:resetpw.php?err=" . urlencode("Account does not exist."));
					exit();			
				}
			}
			catch (PDOException $e)
			{
				echo "Error: ". $e->getMessage(); 
			}
		}
		else
		{
			header("Location:reset.php?err=" . urlencode("Account does not exist."));
			exit();		
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
			<?php $err = htmlentities($_GET['err']); echo $err; ?>
		</div>
		<?php } ?>
	<div>
		<p>Enter new password:</p>
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
					<button type="submit" name="submit">Reset Password</button>
				</div>
			</form>
	</div>
</div>
</body>
<footer>
		<p>© SJRHEEDERS</p>
</footer>
</html>
