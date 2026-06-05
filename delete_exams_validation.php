
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
        

        $stmt = $conn->prepare("SELECT * FROM exams where sub=?");
        $stmt->bind_param("s", $data['dept']);
        $stmt->execute();

        $get = $stmt->get_result();
        $result = $get->fetch_assoc();

        if($result != null){

            $_SESSION['delete_sub_exam'] = $data['dept'];
            
            echo json_encode([

                "success"=> true,

            ]);
            exit();

        }
        else {
            echo json_encode([
                "success"=>false,
                "message"=>"NO exams on above Select Course."
            ]);
        }
       
    }
    else{
        echo json_encode([

            "success"=>false,
            "message"=>"Unable to delete course",
        ]);
        exit();
    }
}

?>
