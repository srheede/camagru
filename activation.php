<?PHP
include 'config/database.php';
if(isset($_GET['token']))
{
    $token = $_GET['token'];
    $query = "update users set status='1' where token='$token'";
    if($pdo->query($query))
    {
        header("Location:login.php?err=Your account has been activated!");
        exit();
    }
}
?>
