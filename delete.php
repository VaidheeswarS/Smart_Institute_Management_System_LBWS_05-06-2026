
<?php


include("db.php");
session_start();

if (
        !isset($_COOKIE['username']) ||
        !isset($_SESSION['username']) ||
        $_COOKIE['username'] !== $_SESSION['username']
    ){

        session_unset();
        session_destroy();

        setcookie("username", "", time() - 3600, "/");

        header("Location: index.html");

        exit();
    }

?>
<div id="DEL">
    
    <form id="deleteform">

        <input type="hidden" name=csrf id="csrf" value="<?php echo $_SESSION['csrf_token'] ?>"> 
        <label for="">Are you sure want to delete your account</label>
        <input type="submit" name="yes" value="Yes"> 
        <input type="submit" name="no" value="No">
    </form>
    
</div>