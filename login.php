<?php
session_start();
if(isset($_SESSION['username']))
{
	header("Location:account.php");
	exit();
}
include 'config/database.php';
if(isset($_POST['submit']))
{
	$username = $_POST['username'];
	$password = hash('haval256,4', $_POST['password']);
	$sql = "select * from users where username='$username' and password='$password'";
	$result = $pdo->query($sql);	
	if ($row = $result->fetch(PDO::FETCH_ASSOC))
	{
		if ($row['status'] == 1)
		{
			$_SESSION = $row;
			header("Location:account.php");
			exit();
		}
		else
		{
			header("Location:login.php?err=". urlencode("User account is not activated."));
			exit();
		}
	}
	else
	{
		header("Location:login.php?err=". urlencode("Username or password incorrect."));
		exit();	
	}
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
