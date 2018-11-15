<?php
include 'config/database.php';
if(isset($_POST['submit']))
{
	if ($_POST['password'] != $_POST['confirm_password'])
	{
		header("Location:register.php?err=" . urlencode("Passwords don't match."));
		exit();
	}
	else if (!isunique($_POST['username']))
	{
		header("Location:register.php?err=" . urlencode("Username already in use."));
		exit();	
	}
	else if (!isunique($_POST['email']))
	{
		header("Location:register.php?err=" . urlencode("Email already registered."));
		exit();	
	}
	$errMsg = '';
	$username = $_POST['username'];
	$password = $_POST['password'];
	if($username == '')
		$errMsg = 'Please enter username.';
	if($password == '')
		$errMsg = 'Please enter password.';
	$token = bin2hex(openssl_random_pseudo_bytes(32));
	$sql = "insert into users (username,email,password,token) values ('$username','$email','$password','$token')";
	$re = $pdo->query($sql);
	$message = "Please click on the following link to confirm your email address: http://localhost:8080/camagru/activation.php?token=$token";
	mail($email, 'camagru registration', $message);
	header("Location:register.php?err=" . urlencode("Your account has successfully been created. Please check your email for the verification link to activate your account."));
	exit();
}
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Login</title>
</head>
<body>
<div>
	<div>
		<p>Login:</p>
		<?php if(isset($_GET['err'])) {?>
		<div>
			<?php echo $_GET['err']; ?>
		</div>
		<?php } ?>
			<form method="post">
				<div>
					<label>Username</label>
					<input type="text" name="username" placeholder="Username" required>
				</div>
				<div>
					<label>Password</label>
					<input type="password" name="password" placeholder="Password" required>
				</div>
				<div>
					<button type="submit" name="submit">Login</button>
				</div>
			</form>
			<p>Not registered yet? <a href="register.php">Register</a></p>
	</div>
</div>
</body>
</html>
