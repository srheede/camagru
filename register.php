<?php
include 'config/database.php';
function isunique($user)
{
	$email = "select * from users where email='$user'";
	$username = "select * from users where username='$user'";
	global $pdo;
	
	$result_email = $pdo->query($email);
	$result_username = $pdo->query($username);
	if ($result_email->rowCount() > 0 || $result_username->rowCount() > 0) {
		return false;
	}
	else {
		return true;		
	}
}
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
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$sql = "insert into users (username,email,password) values ('$username','$email','$password')";
	$re = $pdo->query($sql);
	mail($email, 'camagru registration', 'Please click on the following link to confirm your email address:');
	header("Location:register.php?err=" . urlencode("Your account has successfully been created. Please check your email for the verification link to activate your account."));
	exit();
}
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Register User</title>
</head>
<body>
<div>
	<div>
		<p>Register:</p>
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
					<label>Email</label>
					<input type="email" name="email" placeholder="Email" required>
				</div>
				<div>
					<label>Password</label>
					<input type="password" name="password" placeholder="Password" required>
				</div>
				<div>
					<label>Confirm password</label>
					<input type="password" name="confirm_password" placeholder="Confirm Password" required>
				</div>
				<div>
					<button type="submit" name="submit">Sign up</button>
				</div>
			</form>
			<p class="new-login">Already have an account? <a href="login.php">Login</a></p>
	</div>
</div>
</body>
</html>
