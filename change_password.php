
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

$_SESSION['username'];

$stmt = $conn->prepare("select * from users where email=?");
$stmt->bind_param("s",$_SESSION['username']);
$stmt->execute();

$get = $stmt->get_result();
$res = $get->fetch_assoc();

?>
    <div id="change">
        <form id=changepassword_form>

            <input type="hidden" name="csrf" id="csrf" value="<?php echo $_SESSION['csrf_token'] ?>">
            <input type="text" id="old" name="old" placeholder="Enter Current Password">

            <input type="text" id="new" name="new" placeholder="Enter New Password">
            <input type="text" id="confirm" name="confirm" placeholder="Confirm New Password">
            <input type="submit">
        </form>

    </div>

