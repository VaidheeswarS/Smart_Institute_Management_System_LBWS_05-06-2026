
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

$stmt = $conn->prepare("SELECT * from Department");
$stmt->execute();

$get = $stmt->get_result();


?>

<?php

if($_SERVER['REQUEST_METHOD']=="POST"){
    $data = json_decode(file_get_contents("php://input"),true);
    if($data['token']==$_SESSION['csrf_token']){
        
        $stmt = $conn->prepare("Insert into exams(sub, exam, date) values(?,?,?)");
        $stmt->bind_param("sss", $data['sub'], $data['detail'], $data['date']);
        $stmt->execute();

        echo json_encode([
            "success"=> true,
            "message"=>"Added new Exam",
        ]);
        exit();
    }
    else{
        echo json_encode([

            "success"=>false,
            "message"=>"Unable to add exam",
        ]);
        exit();
    }
}

?>

<div id="add-exam">


<form id="add_exams_form">
    <input type="hidden" name="csrf" id="csrf" value="<?php echo $_SESSION['csrf_token'] ?>">
    
    <select name="sub-name" id="sub-name">
        <?php 
            while ($data = $get->fetch_assoc()){

        ?>
        <option value="<?php echo $data['Dept'] ?>"><?php echo $data['Dept'] ?></option>

        <?php } ?>
    </select>

    <input type="text" name="exam-detail" id="exam-detail" placeholder="Enter Exam Description">
    <input type="date" name="exam-date" id="exam-date">


    <div id=btns>   
        <input type="submit" value="Add Exam">
        <input type="button" id="bak" value="Back">

    </div>

</form>


</div>