
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
        
        $_SESSION['update_sub_exam'] = $dt['dept'];
        
        echo json_encode([
            "success"=> true,
            "message"=>"updating Exam",
        ]);
        exit();
    }
    else{
        echo json_encode([

            "success"=>false,
            "message"=>"Unable to update exam",
        ]);
        exit();
    }
}

?>

<div id="upd-c-exam">
    <form id="update_exam_Confim_form">

        <input type="hidden" name="csrf" id="csrf" value="<?php echo $_SESSION['csrf_token'] ?>">
        <select name="up-exam-sub" id="up-exam-sub">
            <?php 
                while ($data = $get->fetch_assoc()){

            ?>
            <option value="<?php echo $data['exam'] ?>"><?php echo $data['exam'] ?></option>

            <?php } ?>
        </select>
        <?php

        
        
        ?>
        
        <div id="UP-btn">   
            <input type="submit" value="Update data">
            <input type="button" id="upback" value="Back">

        </div>


    


    </form>
</div>



