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
if(isset($_SESSION['username']))
{
	$item .= "
	<div>
		<p>Number of likes: ";
	$item .= $result['likes'];
	$item .= "</p>
	</div>
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
                <textarea type='text' name='username' placeholder='Comment here' required></textarea>
            </div>
            <div>
                <button type='submit' name='submit'>Submit</button>
            </div>
        </form>
	</div>";
	if ($_SESSION['user_id'] === $result['user_id'])
	{
		$delete .= "
		<div>
			<p><a href='image.php?id=";
		$delete .= $image_id;
		$delete .= "&delete=true'>Delete Photo</a></p>
		</div>";
	}
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
		<script>
			document.write('<a href="' + document.referrer + '">Back</a>');
		</script>
        </div>
        <div>
            <img src="images/<?php echo $result['image']; ?>" alt="" height="90%">
        </div>
	<?php echo $delete; echo $item; ?>
    </body>
</html>
