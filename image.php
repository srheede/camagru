<?php
session_start();
include 'config/database.php';
$image_id = $_GET['id'];
$sql = "select * from gallery where image_id='$image_id'";
global $pdo;
$image = $pdo->query($sql);
$result = $image->fetch(PDO::FETCH_ASSOC);
$item;
$delete;
$login;
if(isset($_SESSION['username']))
{
	if ($_SESSION['user_id'] === $result['user_id'])
	{
		$delete .= "
		<div>
			<p><a href='image.php?id=";
		$delete .= $image_id;
		$delete .= "&delete=true'>Delete Photo</a></p>
		</div>";
	}

	$item .= "
    <div>
        <form method='post'>
            <div>
                <button type='submit' name='like'>Like</button>
            </div>
        </form>
    </div>
    <div>
        <form method='post'>
            <div>
                <textarea type='text' name='comment' id='comment' placeholder='Comment here' required></textarea>
            </div>
            <div>
                <button type='submit' name='submit'>Submit</button>
            </div>
        </form>
	</div>";
		
	$logout .= "<p><a href='logout.php'>Logout</a></p>";
}

if (isset($_GET['delete']))
{
	$image_id = $_GET['id'];
	try
	{
		$exec = $pdo->prepare("DELETE FROM gallery WHERE image_id=$image_id");
		$exec->execute();
		header("Location:account.php?err=Image has been deleted!");
		exit();
	}
	catch (PDOException $e)
	{
		echo "Error: ". $e->getMessage(); 
	}
}

if(isset($_POST['like']))
{
	$image_id = $_GET['id'];
	try {
		$exec = $pdo->prepare("UPDATE gallery SET likes = likes + 1 where image_id='$image_id'");
		$exec->execute();
		header("Location:image.php?id=".$image_id);
		exit();
	}
	catch (PDOException $e)
	{
		echo "Error: ". $e->getMessage(); 
	}

	$sql = "select * from gallery where image_id='$image_id'";
	$image = $pdo->query($sql);
	$result = $image->fetch(PDO::FETCH_ASSOC);
	$user_id = $result['user_id'];
	$sql = "select * from users where user_id='$user_id'";
	$user = $pdo->query($sql);
	$result = $user->fetch(PDO::FETCH_ASSOC);
	$email = $result['email'];
	$message = $_SESSION['username']." liked your image.";
	mail($email, 'camagru liked image', $message);
}

if(isset($_POST['submit']))
{	
	$image_id = $_GET['id'];
	$username = $_SESSION['username'];
	$post_comment = $_POST['comment'];
	try {
		$exec = $pdo->prepare("insert into comments (image_id,username,comment) values ('$image_id','$username','$post_comment')");
		$exec->execute();
		header("Location:image.php?id=".$image_id);
		exit();
	}
	catch (PDOException $e)
	{
		echo "Error: ". $e->getMessage(); 
	}

	$sql = "select * from gallery where image_id='$image_id'";
	$image = $pdo->query($sql);
	$result = $image->fetch(PDO::FETCH_ASSOC);
	$user_id = $result['user_id'];
	$sql = "select * from users where user_id='$user_id'";
	$user = $pdo->query($sql);
	$result = $user->fetch(PDO::FETCH_ASSOC);
	$email = $result['email'];
	$message = $_SESSION['username']." commented on your image.";
	mail($email, 'camagru comment on image', $message);
}

$user_id = $_SESSION['user_id'];
$sql = "select * from comments where image_id=$image_id";
$com = $pdo->query($sql);
$comments;
foreach ($com as $comment)
{
	$comments .= "<div><p>$comment->username: $comment->comment</p></div>";
}
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Camagru</title>
    </head>
    <body>
        <div>
			<p><a href="gallery.php">Back</a></p>
        </div>
        <div>
            <img src="images/<?php echo $result['image']; ?>" alt="" height="90%">
        </div>
		<?php echo $delete; ?>
		<div>
		<p>Number of likes: <?php echo $result['likes']; ?></p>
		</div>
		<?php echo $item; echo $comments; echo $logout; ?>
    </body>
</html>
