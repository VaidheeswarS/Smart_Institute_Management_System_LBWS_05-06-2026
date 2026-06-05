
<?php
    include("db.php");
    session_start();    


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


    
?>

<?php


    if($_SERVER['REQUEST_METHOD']=="POST"){
        
        $value = json_decode(file_get_contents("php://input"),true);
        $email = trim($value['email']);
        $password = trim($value['password']);

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        if($data==null){
            echo json_encode([
                "success"=>false,
                "message"=>"Email id not registered.",
            ]);
            exit();
        }
        else{
            if (password_verify($password, $data['password'])){

                setcookie("username", $email, time()+3600, "/");
                
                $_SESSION['username'] = $email;
            
                $user_type = $data['designation'];
                $name = $data['name'];

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
                    $mail->addAddress($email);

                        // Email Content
                    $mail->isHTML(true);

                    $mail->Subject = 'Test Mail';

                    $mail->Body    = "
                            <h2>Dear {$name},</h2>
                            <p>This email is from Institute. you have been Logged in successfully.</p>
                            <p>This email was sent using SMTP in PHP.</p>
                        ";

                    $mail->send();

                } catch (Exception $e) {
                        echo "email not sent";
                        exit();
                }
                // echo "Login successful";
                echo json_encode([
                    "success"=> true,
                    "message"=>"Login Successful",
                    "user_type"=> $data['designation']
                ]);
                exit();

            }
            else{
                echo json_encode([
                    "success"=> false,
                    "message"=>"Invalid Password."

                ]);
                exit();
            }
        }

    }
    

?>

