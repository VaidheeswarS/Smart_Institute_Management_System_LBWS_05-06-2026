
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

    $dept = $_SESSION['depart'];

    $stmt = $conn->prepare("SELECT * from Department where Dept=?");
    $stmt->bind_param("s", $dept);
    $stmt->execute();

    $get = $stmt->get_result();
    $data = $get->fetch_assoc();


?>

<?php

if($_SERVER['REQUEST_METHOD']=="POST"){
    $value = json_decode(file_get_contents("php://input"), true);

    if($value['token']==$_SESSION['csrf_token']){
        $stmt = $conn->prepare("UPDATE Department SET Dept=?, about=?, duration=?, fees=? where id=?");
        $stmt->bind_param("ssssi",$value['department'], $value['about'], $value['duration'], $value['fees'], $data['id']);
        $stmt->execute();

        echo json_encode([
            "success"=>true,
            "message"=>"Course udpated by Admin."

        ]);
        exit();
    }
    else{
        echo json_encode([
            "success"=>false,
            "message"=>"Unable to update course."
        ]);
        exit();
    }


}


?>

<div id="u"> 
<form id="update_course">

    <div class="course">
        
        <input type="hidden" name="csrf" id="csrf" value="<?php echo $_SESSION['csrf_token'] ?>">

        <label for="">Department:</label><input type="text" name="department" id="department" value="<?php echo $data['Dept'] ?>">
        
        <label for="">About:</label><input type="text" name="about" id="about" value="<?php echo $data['about'] ?>">

        <label for="">Duration:</label><input type="text" name="duration" id="duration" value="<?php echo $data['duration'] ?>"> 

        <label for="">Fees:</label> <input type="text" name="fees" id="fees" value=" <?php echo $data['fees'] ?>">

        <div id=upc>
            <input type="submit" name="updatebtn" id="update-btn" value="update">
            <input type="submit" name="back" id="back" value="Back">
        </div>

    </div>
</form>
</div>