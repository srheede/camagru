<?php
	session_start();
	include 'config/database.php';
	if(!isset($_SESSION['username']))
	{
		header("Location:login.php?err=". urlencode("You are not logged in to an account."));
		exit();
	}
	if (isset($_POST['upload'])) {
		$date = date('Y-m-d H:i:s');
		$image = $_FILES['image']['name'];
		$target = "images/".basename($image);
		$user_id = $_SESSION['user_id'];
		try {
			$exec = $pdo->prepare("INSERT INTO gallery (date, image, user_id) VALUES ('$date', '$image', '$user_id')");
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
	if (isset($_POST['save']))
	{
		$date = date('Y-m-d H:i:s');
		$user_id = $_SESSION['user_id'];
		define('UPLOAD_DIR', 'images/');
		$img = $_POST['dataURL'];
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$img_name = uniqid() . '.png';
		$file = UPLOAD_DIR . $img_name;
		$success = file_put_contents($file, $data);
		if ($success)
		{
			try
			{
				$exec = $pdo->prepare("INSERT INTO gallery (date, image, user_id) VALUES ('$date', '$img_name', '$user_id')");
				$exec->execute();
				header("Location:account.php?err=Image saved successfully!");
				exit();
			}
			catch (PDOException $e)
			{
				echo "Error: ". $e->getMessage(); 
			}
		}
		else
		{
			header("Location:account.php?err=Unable to save image.");
			exit();
		}
	}
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?php $name = htmlentities($_SESSION['username']); echo $name; ?></title>
</head>
<body>
<?php if(isset($_GET['err'])) {?>
	<div>
		<?php $err = htmlentities($_GET['err']); echo $err; ?>
	</div>
<?php } ?>
<a href="#" id="capture"><video id="video" width="400px" height="300px"></video></a>
<canvas id="canvas" width="400px" height="300px"></canvas>
<p><img id="classified" src="stickers/classified.png" height="80px"><img id="pedobear" src="stickers/pedobear.png" height="80px"><img id="oooh" src="stickers/oooh.png" height="80px"></p>
<form method="post">
	<div>
		<input type="hidden" value="" name="dataURL" id="dataURL">
		<button type="submit" name="save" id="save">Save Photo</button>
	</div>
</form>
<script src="photo.js"></script>
<div>
<p>Upload Image</p>
<form method="POST" action="account.php" enctype="multipart/form-data">
  	<div>
  	  <input type="file" name="image" accept=".jpg,.jpeg,.png,.gif,.bmp,.tif,.tiff">
  	</div>
  	<div>
  		<button type="submit" name="upload">POST</button>
  	</div>
  </form>
  </div>
<p><a href="gallery.php">View Personal Gallery</a></p>
<p><a href="publicgallery.php">View Public Gallery</a></p>
<p><a href="changedetails.php">Change Account Details</a></p>
<p><a href="logout.php">Logout</a></p>
</body>
<footer>
		<p>© SJRHEEDERS</p>
</footer>
</html>
