<?php
session_start();
include 'config/database.php';
$item;
if(isset($_SESSION['username']))
{
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
                <textarea type='text' name='username' placeholder='Comment here' required></textarea>
            </div>
            <div>
                <button type='submit' name='submit'>Submit</button>
            </div>
        </form>
    </div>";
}
$image_id = $_GET['id'];
$sql = "select * from gallery where image_id='$image_id'";
global $pdo;
$image = $pdo->query($sql);
$result = $image->fetch(PDO::FETCH_ASSOC);
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Camagsdu</title>
    </head>
    <body>
        <div>
            <a class="back" href="gallery.php">back</a>
        </div>
        <div>
            <img src="images/<?php echo $result['image']; ?>" alt="" height="90%">
        </div>
    <?php echo $item; ?>
    </body>
</html>