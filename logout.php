
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

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


    
if($_SERVER['REQUEST_METHOD']=="POST"){
    $value = json_decode(file_get_contents("php://input"), true);

    if($value['token']==$_SESSION['csrf_token']){
        
        $email = $_COOKIE['username'];
        
        $stmt = $conn->prepare("SELECT * from users where email =?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $get = $stmt->get_result();
        $result = $get->fetch_assoc();
        $name = $result['name'];


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
                    <p>This email is from Institute. you have been Logged out successfully.</p>
                    <p>This email was sent using SMTP in PHP.</p>
                ";

            $mail->send();

        } catch (Exception $e) {
                echo "email not sent";
                exit();
        }
        session_destroy();
        
        setcookie("username","",time()-3600, "/");
        unset($_COOKIE['username']);

        echo json_encode([
            "success"=>true,
            "message"=>"Logged out."

        ]);
        exit();
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


<div id="out">


    <form id="logout">
        <div>
            Are you sure want to logout?
        </div>

        <div>
            <input type="hidden" name="csrf" id="csrf" value="<?php echo $_SESSION['csrf_token'] ?>">
            <input type="submit" name="yes" id="yes" value=Yes>
            <input type="submit" name="no" id="no" value=No>

        </div>
    </form>

</div>