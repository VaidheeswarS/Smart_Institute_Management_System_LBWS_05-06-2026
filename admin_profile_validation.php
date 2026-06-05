
<?php
     include("db.php");

?>


<?php

session_start();
$email = $_SESSION['username'];
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


if($_SERVER["REQUEST_METHOD"]=="POST"){

    $data = json_decode(file_get_contents("php://input"),true);
    if ($data['token']==$_SESSION['csrf_token']){
        
        $_SESSION['name'] = $data['name'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['phone'] = $data['phone'];
        $_SESSION['aadhar'] = $data['aadhar'];
        $_SESSION['password'] = $data['password'];

        echo json_encode([
            "success"=>true,
            "message"=>"Data verified",
        ]);
        exit();
    }
    else{
        echo json_encode([
            "success"=>false,
            "message"=>"Invalid token"
        ]);
        exit();
    }

}



?>