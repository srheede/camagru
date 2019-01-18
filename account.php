<?php
	session_start();
	include 'config/database.php';
	if(!isset($_SESSION['username']))
	{
		header("Location:login.php?err=". urlencode("You are not logged in to an account."));
		exit();
	}
	if (isset($_POST['upload'])) {
		$image = $_FILES['image']['name'];
		$target = "images/".basename($image);
		$user_id = $_SESSION['user_id'];
		try {
			$exec = $pdo->prepare("INSERT INTO gallery (image, user_id) VALUES ('$image', '$user_id')");
			$exec->execute();
			if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
				header("Location:account.php?err=Image uploaded successfully!");
				exit();
			}
			else
			{
				header("Location:account.php?err=Image upload failed.");
				exit();
			}
		}
		catch (PDOException $e)
		{
			echo "Error: ". $e->getMessage(); 
		}
	}
	if (isset($_POST['save'])) {
		$image = $_POST['dataURL'];
		$user_id = $_SESSION['user_id'];
		try {
			header("Location:account.php?err=Image uploaded successfully!");
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
	<title><?php echo $_SESSION['username']; ?></title>
</head>
<body>
<?php if(isset($_GET['err'])) {?>
	<div>
		<?php echo $_GET['err']; ?>
	</div>
<?php } ?>
<video id="video" width="400px" height="300px"></video>
<canvas id="canvas" width="400px" height="300px"></canvas>
<p><a href="#" id="capture">Take Photo</a></p>
<form method="post" action="account.php">
	<div>
		<input type="text" name="dataURL" style="display:none" id="dataURL"/>
		<button type="submit" name="save">Save Photo</button>
	</div>
</form>
<script src="photo.js"></script>
<div>
<p>Upload Image</p>
<form method="POST" action="account.php" enctype="multipart/form-data">
<input type="hidden" name="size" value="1000000">
  	<div>
  	  <input type="file" name="image">
  	</div>
  	<div>
  		<button type="submit" name="upload">POST</button>
  	</div>
  </form>
  </div>
<p><a href="gallery.php">View Personal Gallery</a></p>
<p><a href="publicgallery.php">View Public Gallery</a></p>
<p><a href="changedetailsmail.php">Change Account Details</a></p>
<p><a href="logout.php">Logout</a></p>
</body>
</html>
