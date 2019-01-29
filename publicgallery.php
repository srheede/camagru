<?php
session_start();
include 'config/database.php';

if (isset($_GET['page']))
    $page = $_GET['page'];
else 
    $page = 1;

$offset = ($page - 1) * 5;
$sql = "SELECT * FROM gallery ORDER BY user_id, date  LIMIT $offset, 5";
global $pdo;
$gallery = $pdo->query($sql);
$item;
foreach ($gallery as $image)
{
$item .= "<a href='image.php?id=$image->image_id'>" .
    
    "<img src='images/$image->image' alt='' height='30%'>" .
            "</a>";
}

$logout;
if(isset($_SESSION['username']))
{
    $back .= "
    <div>
        <a class='back' href='account.php'>back</a>
    </div>";

    $logout .= "<p><a href='logout.php'>Logout</a></p>";
}
else
{
    $back .= "
    <div>
        <a class='home' href='index.php'>home</a>
    </div>";
}
    
    $sql = "select count(*) from gallery";
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
        <?php echo $back; echo $item; ?>
        <div>
            <?php echo $pagination; ?>
        </div>
        <?php echo $logout; ?>
        </div>
    </body>
	<footer>
		<p>© SJRHEEDERS</p>
	</footer>
</html>