
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
    $stmt = $conn->prepare("SELECT * FROM exams where sub=?");
    $stmt->bind_param("s", $_SESSION['delete_sub_exam']);
    $stmt->execute();

    $get = $stmt->get_result();

?>

<?php

if($_SERVER['REQUEST_METHOD']=="POST"){
    $dt = json_decode(file_get_contents("php://input"),true);
    if($dt['token']==$_SESSION['csrf_token']){
        
    
        $stmt = $conn->prepare("DELETE from exams where exam=?");
        $stmt->bind_param("s", $dt['dept']);
        $stmt->execute(); 

        echo json_encode([
            "success"=> true,
            "message"=>"Deleted a Exam",
        ]);
        exit();
    }
    else{
        echo json_encode([

            "success"=>false,
            "message"=>"Unable to delete exam",
        ]);
        exit();
    }
}

?>


<div id="del-exam-c">
    <form id="delete_exam_Confim_form">

        <input type="hidden" name="csrf" id="csrf" value="<?php echo $_SESSION['csrf_token'] ?>">
        <select name="del-exam-sub" id="del-exam-sub">
            <?php 
                while ($data = $get->fetch_assoc()){

            ?>
            <option value="<?php echo $data['exam'] ?>"><?php echo $data['exam'] ?></option>

            <?php } ?>
        </select>
        <?php

        
        
        ?>
        <div id="DEL-btn">   
            <input type="submit" value="Delete">
            <input type="button" id="delback" value="Back">

        </div>



    </form>

</div>