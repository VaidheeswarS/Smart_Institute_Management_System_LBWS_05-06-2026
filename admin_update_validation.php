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

        if ($_POST['csrf']==$_SESSION['csrf_token']){

            $name = htmlspecialchars($_POST['uname']);
            $email = htmlspecialchars($_POST['uemail']);
            $phone = htmlspecialchars($_POST['uphone']);

            $org_file = $_FILES['uaadhar']['name'];
            $temp_file = $_FILES['uaadhar']['tmp_name'];

            $user = $_SESSION['username'];
            $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
            $stmt->bind_param("s",$user);
            $stmt->execute();

            $get = $stmt->get_result();
            $result = $get->fetch_assoc();

            if($org_file==null || $org_file==""){
                $old = htmlspecialchars($_POST['oldaadhar']);
                
                $stmt = $conn->prepare("update users SET name =?, email =?, phone =?, aadhar=? where id=?");
                $stmt->bind_param("ssssi",$name, $email, $phone, $old, $result['id']);
                $stmt->execute();
                $_SESSION['username'] = $email;

                echo json_encode([
                "success" => true,
                "message"=> "Data updated"
                ]);
                exit();

            }
            else{
                $FILE_TYPE = strtolower(pathinfo($org_file, PATHINFO_EXTENSION));

                if($FILE_TYPE=="pdf"){
                    move_uploaded_file($temp_file,"uploads/".$org_file);
                    $stmt = $conn->prepare("update users SET name =?, email =?, phone =?, aadhar=? where id=?");
                    $stmt->bind_param("ssssi",$name, $email, $phone, $org_file, $result['id']);
                    $stmt->execute();
                    $_SESSION['username'] = $email;
                    echo json_encode([
                    "success" => true,
                    "message"=> "Data updated"
                    ]);
                    exit();

                }
                else{
                    echo json_encode([
                        "success"=> false,
                        "message"=> "Invalid File type, Pdf file prefered."                                         
                    ]);
                    exit();
                    
                }
                
            };

        }
        else{
            echo json_encode([
                "success"=>false,
                "message"=>"Invalid Token"
            ]);
            exit();
        };
    };
?>