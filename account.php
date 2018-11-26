<?php
	session_start();
	include 'config/database.php';
	if(!isset($_SESSION['username']))
	{
		header("Location:login.php?err=". urlencode("You are not logged in to an account."));
		exit();
	}
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?php echo $_SESSION['username']; ?></title>
</head>
<body>
<?php if(isset($_GET['err'])) {?>
	<div>
		<?php echo $_GET['err']; ?>
	</div>
<?php } ?>
<video id="video" width="400px" height="300px"></video>
<a href="#" id="capture">Take Photo</a>
<canvas id="canvas" width="400px" height="300px"></canvas>
<img id="photo" src="" alt="">
<script src="photo.js"></script>
<p><a href="changepwmail.php">Change Password</a></p>
<p><a href="logout.php">Logout</a></p>
</body>
</html>
