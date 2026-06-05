
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

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



if($_SERVER['REQUEST_METHOD']=="POST"){
    $data = json_decode(file_get_contents("php://input"),true);
    if($data['token']==$_SESSION['csrf_token']){


        $stmt = $conn->prepare("SELECT * from users where email =?");
        $stmt->bind_param("s", $data['user']);
        $stmt->execute();

        $get = $stmt->get_result();
        $result = $get->fetch_assoc();

        if(!$result){

            echo([
                "success"=>false,
                "message"=>"Unable to find user to delete"
            ]);
            exit();

        }
        else
        {
            $name = $result['name'];
            
            require 'vendor/autoload.php';

            $mail = new PHPMailer(true);

            $stmt = $conn->prepare("DELETE from users where id=?");
            $stmt->bind_param("i", $result['id']);

            try {

                // SMTP settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                    
                    // Your Gmail
                $mail->Username   = 'vaidheeswarsridharan@gmail.com';
                    
                // Gmail App Password
                $mail->Password   = 'ompf xauu ndht macq';
                    
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                    // Sender
                $mail->setFrom('vaidheeswarsridharan@gmail.com', 'Admin');

                    // Receiver
                $mail->addAddress($result['email']);

                    // Email Content
                $mail->isHTML(true);

                $mail->Subject = 'Test Mail';

                $mail->Body    = "
                        <h2>Dear Trainer {$name},</h2>
                        <p>This email is from Institute. your account had been Deleted by admin. any queries contact admin.</p>
                        <p>This email was sent using SMTP in PHP.</p>
                    ";

                $mail->send();
                $stmt->execute();

            } catch (Exception $e) {
                    echo json_encode([
                        "success" => false,
                        "message" => "mail not sent"
                    ]);
                    exit();
            }
            echo json_encode([
                    "success" => true,
                    "message" => "Deleted Staff ".$result['email']
            ]);
        }

    }
    else{
        echo json_encode([
            "success"=>false,
            "message"=>" invalid token"
        ]);
        exit();

    }
    
}

?>