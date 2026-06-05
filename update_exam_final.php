
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


    $dept = $_SESSION['update_sub_exam'];

    $stmt = $conn->prepare("SELECT * from exams where exam=?");
    $stmt->bind_param("s", $dept);
    $stmt->execute();

    $get = $stmt->get_result();
    $data = $get->fetch_assoc();


?>

<?php

if($_SERVER['REQUEST_METHOD']=="POST"){
    $value = json_decode(file_get_contents("php://input"), true);

    if($value['token']==$_SESSION['csrf_token']){
        $stmt = $conn->prepare("UPDATE exams SET exam=? where id=?");
        $stmt->bind_param("si",$value['exam_detail'], $data['id']);
        $stmt->execute();

        echo json_encode([
            "success"=>true,
            "message"=>"Exam udpated by Admin."

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

<div id="upd-final">


    <form id="update_exam_final">

        <div>
            
            <input type="hidden" name="csrf" id="csrf" value="<?php echo $_SESSION['csrf_token'] ?>">

            <label for="">Exam details</label><input type="text" name="exam_detail" id="exam_detail" value="<?php echo $data['exam'] ?>">
        
            
            

            <div id="upd-final-btn">   
                <input type="submit" name="updatebtn" id="update-btn" value="update">
                <input type="button" id="final" value="Back">

            </div>  

        </div>
    </form>
</div>