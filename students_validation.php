
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

        $stmt = $conn->prepare("SELECT * from users where email=?");
        $stmt->bind_param("s", $data['user']);
        $stmt->execute();

        $get = $stmt->get_result();
        $result = $get->fetch_assoc();

        if($result['user_status']==1){
            $stmt = $conn->prepare("UPDATE USERS SET user_status=? where id=?");
            $num = 2;
            $stmt->bind_param("ii",$num, $result['id']);
            $stmt->execute();
            
            require 'vendor/autoload.php';

            $mail = new PHPMailer(true);

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
                    <h2>Dear Student {$result['name']},</h2>
                    <p>This email is from Institute. your account had been Deactivated by admin. any queries contact admin to activate account.</p>
                    <p>This email was sent using SMTP in PHP.</p>
                ";

                $mail->send();

                
            } catch (Exception $e) {

                echo json_encode([
                    "success"=>true,
                    "message"=>"Deactivated Student, error on sending email to student."
                ]);
                exit();
            };
            echo json_encode([
                "success"=>true,
                "message"=>"Deactivated Student, email sent to Student."
            ]);
            exit();
          
        }
        else{
            $stmt = $conn->prepare("UPDATE USERS SET user_status=? where id=?");
            $num = 1;
            $stmt->bind_param("ii",$num, $result['id']);
            $stmt->execute();

            require 'vendor/autoload.php';

            $mail = new PHPMailer(true);

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
                    <h2>Dear Student {$result['name']},</h2>
                    <p>This email is from Institute. your account had been Activated by admin. any queries contact admin.</p>
                    <p>This email was sent using SMTP in PHP.</p>
                ";

                $mail->send();

                
            } catch (Exception $e) {

                echo json_encode([
                    "success"=>true,
                    "message"=>"Activated Student, error on sending email to student."
                ]);
                exit();
            };
            echo json_encode([
                "success"=>true,
                "message"=>"Activated Student, email sent to Student."
            ]);
            exit();
            
        }

    }
    else{
        echo json_encode([
            "success"=>false,
            "message"=>"invalid token"
        ]);
        exit();

    }
    
}

?>