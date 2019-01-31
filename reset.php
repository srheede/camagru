<?php
include 'config/database.php';
if(isset($_POST['submit']))
{
	$email = $_POST['email'];
	$check = "select * from users where email='$email'";
	global $pdo;

	$result_check = $pdo->query($check);
	if ($result_check->rowCount() > 0)
	{
		$token = bin2hex(openssl_random_pseudo_bytes(32));
		try {
			$exec = $pdo->prepare("UPDATE users SET pwtoken='$token' where email='$email'");
			$exec->execute();
		}
		catch (PDOException $e)
		{
			echo "Error: ". $e->getMessage(); 
		}
		$message = "Please click on the following link to reset your password: http://localhost:8080/camagru/resetpw.php?token=$token";
		mail($email, 'camagru reset password', $message);
		header("Location:reset.php?err=" . urlencode("Please check your email to reset your password."));
		exit();
	}
	else
	{
		header("Location:reset.php?err=" . urlencode("This email is not registered."));
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
		<p>Please enter your email address:</p>
			<form method="post" action="reset.php">
				<div>
					<input type="email" name="email" placeholder="Email Address" required>
				</div>
				<div>
					<button type="submit" name="submit">Submit</button>
				</div>
			</form>
	</div>
	<div>
            <a class="back" href="login.php">back</a>
    </div>
</div>
</body>
<footer>
		<p>© SJRHEEDERS</p>
</footer>
</html>
