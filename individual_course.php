
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

$stmt = $conn->prepare("SELECT * FROM users where email=?");
$stmt->bind_param("s",$_SESSION['username']);

$stmt->execute();
$get = $stmt->get_result();
$user = $get->fetch_assoc();

$stmt = $conn->prepare("SELECT * from Department where id=?");
$stmt->bind_param("i",$user['user_department']);
$stmt->execute();

$get = $stmt->get_result();
$data = $get->fetch_assoc();
?>


<div id="ind">
    <form id="individual">

        <h3>Your Selected Course</h3>

        <h2><?php echo htmlspecialchars($data['Dept']); ?></h2>

        <p>
            <?php echo nl2br(htmlspecialchars($data['about'])); ?>
        </p>

        <p>
            <strong>Duration:</strong>
            <?php echo htmlspecialchars($data['duration']); ?>
        </p>

        <p>
            <strong>Fees:</strong>
            ₹<?php echo htmlspecialchars($data['fees']); ?>
        </p>

        <input type="submit" id="back" value="Back">

    </form>
</div>