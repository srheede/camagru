<?PHP
include 'config/database.php';
if(isset($_GET['token']))
{
    $token = $_GET['token'];
    try
    {
        $exec = $pdo->prepare("update users set status='1' where token=?");
        $exec->execute(array($token));
        header("Location:login.php?err=Your account has been activated!");
        exit();
    }
    catch (PDOException $e)
    {
        echo "Error: ". $e->getMessage(); 
    }
}
?>
