
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
        $value = json_decode(file_get_contents("php://input"), true);

        if($value['token'] == $_SESSION['csrf_token']){

            $stmt = $conn->prepare("SELECT * from users where email = ?");
            $stmt->bind_param("s",$_SESSION['username']);
            $stmt->execute();

            $get = $stmt->get_result();
            $data = $get->fetch_assoc();

            $stmt = $conn->prepare("DELETE from users where id=?");
            $stmt->bind_param("i", $data['id']);
            $stmt->execute();

            session_destroy();
            echo json_encode([
               "success" => true,
               "message" =>"Account Deleted Successfully"
            ]);
            exit();

        }
        else{
            echo json_encode([
                "success"=> false,
                "message"=>"Invalid token"

            ]);
            exit();

        }
    }







?>
