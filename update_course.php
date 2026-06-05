
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

<?php

if($_SERVER['REQUEST_METHOD']=="POST"){
    $data = json_decode(file_get_contents("php://input"),true);
    if($data['token']==$_SESSION['csrf_token']){
        

        // $stmt = $conn->prepare("SELECT * FROM Department where Dept=?");
        // $stmt->bind_param("s", $data['dept']);
        // $stmt->execute();

        // $get = $stmt->get_result();
        // $result = $get->fetch_assoc();


        // $stmt = $conn->prepare("DELETE from Department where id=?");
        // $stmt->bind_param("i", $result['id']);
        // $stmt->execute();
        $_SESSION['depart'] = $data['dept'];
        echo json_encode([
            "success"=> true,
            "message"=>"course update process",
        ]);
        exit();
    }
    else{
        echo json_encode([

            "success"=>false,
            "message"=>"Unable to update course",
        ]);
        exit();
    }
}

?>



<?php
// 
$stmt = $conn->prepare("SELECT * from Department");
$stmt->execute();

$get = $stmt->get_result();

?>
<div id="upc">
<form id="update_course_form">

    <input type="hidden" name="csrf" id="csrf" value="<?php echo $_SESSION['csrf_token'] ?>">
    <select name="del" id="up-c">
        <?php 
            while ($data = $get->fetch_assoc()){

        ?>
        <option value="<?php echo $data['Dept'] ?>"><?php echo $data['Dept'] ?></option>

        <?php } ?>
    </select>

    <div id="up">
        <input type="submit" name="choose_course" value="Choose Course">
        <input type="submit" name="back" id="back" value="Back">
    </div>




</form>