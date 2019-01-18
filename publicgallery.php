<?php
include 'config/database.php';
$sql = "select * from gallery";
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
    </body>
</html>