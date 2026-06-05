
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

if($_SERVER['REQUEST_METHOD']=="POST"){

    $data = json_decode(file_get_contents("php://input"),true);

    if($data['token']==$_SESSION['csrf_token']){
        
        $_SESSION['Dept'] = $data['dept'];
        echo json_encode([
            "success"=> true,
            "message"=>"Show data"
        ]);
    }
    else{
        echo json_encode([
            "success"=> false,
            "message"=>"Invalid token"
        ]);
    }

}

?>