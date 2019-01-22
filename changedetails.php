<?php
session_start();
if(!isset($_SESSION['username']))
{
	header("Location:login.php?err=" . urlencode("Please log in to your account."));
	exit();
}
include 'config/database.php';
function isunique($user)
{
	$user_id = $_SESSION['user_id'];
	$sql = "select * from users where user_id='$user_id'";
	global $pdo;
	
	$result = $pdo->query($sql);
	$result = $result->fetch(PDO::FETCH_ASSOC);
	if ($user === $result['username'])
		return true;
	if ($user === $result['email'])
		return true;	
	$email = "select * from users where email='$user'";
	$username = "select * from users where username='$user'";
	
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
		$user_id = $_SESSION['user_id'];
		if (!isunique($_POST['username']))
		{
			header("Location:changedetails.php?err=" . urlencode("Username is already in use."));
			exit();	
		}
		else if (!isunique($_POST['email']))
		{
			header("Location:changedetails.php?err=" . urlencode("Email is already in use."));
			exit();	
		}
		else if ($_POST['password'] != $_POST['confirm_password'])
		{
			header("Location:changedetails.php?err=" . urlencode("Passwords don't match."));
			exit();
		}
		else if (!preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $_POST['password']))
		{
			header("Location:changedetails.php?err=" . urlencode("Password must contain numbers and letters."));
			exit();
		}
		echo $token;		
		$password = hash('haval256,4', $_POST['password']);
		$username = $_POST['username'];
		$email = $_POST['email'];
		if (isset($_POST['notify']))
			$notify = 1;
		else
			$notify = 0;
		try {
			$exec = $pdo->prepare("UPDATE users SET username='$username', email='$email', password='$password', notify='$notify' where user_id='$user_id'");
			$exec->execute();
			header("Location:account.php?err=Your details have been changed!");
			exit();
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
	<title>Change Account Details</title>
</head>
<body>
<div>
	<div>
		<p>Please enter your new details:</p>
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
					<input type="text" name="email" placeholder="Email" required>
				</div>				
				<div>
					<label>Password</label>
					<input type="password" name="password" placeholder="Password" required>
				</div>
				<div>
					<label>Confirm password</label>
					<input type="password" name="confirm_password" placeholder="Confirm Password" required>
				</div>
				<input type="checkbox" name="notify" value="notify" checked> Send me email notifications.<br>
				<div>
					<button type="submit" name="submit">Save New Details</button>
				</div>
			</form>
			<p>Don't want to change your details? <a href="account.php">Return To Account</a></p>
	</div>
</div>
</body>
</html>
