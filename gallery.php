<?php
session_start();
include 'config/database.php';
if(!isset($_SESSION['username']))
{
	header("Location:login.php?err=". urlencode("You are not logged in to an account."));
	exit();
}

if (isset($_GET['page']))
    $page = $_GET['page'];
else 
    $page = 1;

$user_id = $_SESSION['user_id'];
$offset = ($page - 1) * 5;
$sql = "SELECT * FROM gallery WHERE user_id='$user_id' ORDER BY DATE LIMIT $offset, 5";
global $pdo;
$gallery = $pdo->query($sql);

$sql = "select count(*) from gallery where user_id='$user_id'";
$count = $pdo->query($sql);
$count = $count->fetch(PDO::FETCH_ASSOC);
$total_pages = ceil($count['count(*)']/5);
$pagination;

if ($page > 1)
    $pagination .= "<a href='?page=1'><<</a> <a href='?page=".($page - 1)."'><</a> ";

if ($total_pages > 1)
{
    $count = 1;

    while ($count <= $total_pages)
    {
        $pagination .= "<a href='?page=".$count."'> ".$count." </a>";
        $count = $count + 1;
    }
}

if ($page < $total_pages)
{
    $pagination .= "<a href='?page=".($page + 1)."'>></a> <a href='?page=$total_pages'>>></a>";
}

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
        <div>
            <?php echo $pagination; ?>
        </div>
        <p><a href='logout.php'>Logout</a></p>
    </body>
	<footer>
		<p>© SJRHEEDERS</p>
	</footer>
</html>
