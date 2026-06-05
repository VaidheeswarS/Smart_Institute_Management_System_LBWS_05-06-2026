
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

    $dept = $_SESSION['Dept'];

    $stmt = $conn->prepare("SELECT * from Department where Dept=?");
    $stmt->bind_param("s", $dept);
    $stmt->execute();

    $get = $stmt->get_result();
    $data = $get->fetch_assoc();


?>

<div id=view-c>


    <form id="cd-form">

        
        <h2> <?php echo $data['Dept'] ?></h2>
        
        <p> <?php echo $data['about'] ?></p>

        <p>Duration: <?php echo $data['duration'] ?></p>

        <p>Fees: <?php echo $data['fees'] ?></p>

        <input type="submit" name="back" id="back" value="Back">



    </form>

</div>