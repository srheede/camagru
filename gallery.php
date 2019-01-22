<?php
session_start();
include 'config/database.php';
if(!isset($_SESSION['username']))
{
	header("Location:login.php?err=". urlencode("You are not logged in to an account."));
	exit();
}
$user_id = $_SESSION['user_id'];
$sql = "select * from gallery where user_id='$user_id'";
global $pdo;
$gallery = $pdo->query($sql);
$item;
foreach ($gallery as $image)
{
$item .= "<a href='image.php?id=$image->image_id'>" .
    
    "<img src='images/$image->image' alt='' height='30%'>" .
            "</a>";
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
            <a class="back" href="account.php">back</a>
        </div>
        <div>
        <?php echo $item; ?>
        </div>
        <p><a href='logout.php'>Logout</a></p>
    </body>
</html>