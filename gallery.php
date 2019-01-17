<?php
include 'config/database.php';
$user_id = 1;
$sql = "select image from gallery where user_id='$user_id'";
global $pdo;
$gallery = $pdo->query($sql);
$item;
$id= 1;
foreach ($gallery as $image)
{
       $item .= "<a href='/image.php?id=$id'>" .
    
    "<img src='images/$image->image' alt='' width='420'>" .
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