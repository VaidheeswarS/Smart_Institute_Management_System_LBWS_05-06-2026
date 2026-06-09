
<?php

    include("db.php");

    $stmt = $conn->prepare("SELECT * from Department");
    $stmt->execute();

    $get = $stmt->get_result();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

?>


<?php
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $count = 0;
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $designation = htmlspecialchars($_POST['designation']);
        $dept = htmlspecialchars($_POST['dept']);
        $phone = htmlspecialchars($_POST['Phone']);
        $password = htmlspecialchars($_POST['password']);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $org_add = $_FILES['address']['name'];
        $temp_add =$_FILES['address']['tmp_name'];

        $add_filetype = strtolower(pathinfo($org_add, PATHINFO_EXTENSION));
        if($add_filetype!="pdf"){
            echo ("for Aadhar only pdf file is allowed.");
            exit();
        }
        else{
            move_uploaded_file($temp_add,"uploads/".$org_add);

            $stmt = $conn->prepare("SELECT * from Department where Dept=?");
            $stmt->bind_param("s",$dept);
            $stmt->execute();
            $get = $stmt->get_result();
            $data = $get->fetch_assoc();
            $dept_id = $data['id'];

            $stmt = $conn->prepare("SELECT * from users");
            $stmt->execute();

            $get = $stmt->get_result();
            while($gmail = $get->fetch_assoc()){
                if($gmail['email']==$email){

                    $count = $count+1;
                    echo "Email id already exists.";
                    exit();
                }
            }

            if($count==0){
                if($designation!=="Staff"){
                    $query = "insert into users(name, email, designation, phone, password, aadhar, user_department) values('$name','$email', '$designation', '$phone', '$hashed_password', '$org_add','$dept_id')";
                    try{
                        mysqli_query($conn, $query);
                        
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
                                    <h2>Dear {$designation} {$name},</h2>
                                    <p>This email is from Institute. your account had been Created successfully, any queries contact admin.</p>
                                    <p>This email was sent using SMTP in PHP.</p>
                                ";

                            $mail->send();

                        } catch (Exception $e) {
                                echo "email not sent";
                                exit();
                        }
                        echo"User Registered successfully"; 
                        exit();
                                    // header("Location: ");
                    }
                    catch(Exception $e){
                        echo"There was an error on data while providing, kindly check.";
                        exit();
                    }
                }
                else{

                    $org_staff = $_FILES['staff_certificate']['name'];
                    $temp_name = $_FILES['staff_certificate']['tmp_name'];

                    $staff_filetype = strtolower(pathinfo($org_staff, PATHINFO_EXTENSION));

                    $allowed = ["pdf", "doc", "docx"];

                    if (in_array($staff_filetype, $allowed)){
        
                        move_uploaded_file($temp_name, "uploads/".$org_staff);
                        $query = "insert into users(name, email, designation, staff_certificate, phone, password, aadhar, user_department) values('$name','$email', '$designation', '$org_staff', '$phone', '$hashed_password', '$org_add','$dept_id')";

                        try{
                            mysqli_query($conn, $query);
                            
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
                                        <h2>Dear {$designation} {$name},</h2>
                                        <p>This email is from Institute. your account had been Created successfully, any queries contact admin.</p>
                                        <p>This email was sent using SMTP in PHP.</p>
                                    ";

                                $mail->send();

                            } catch (Exception $e) {
                                    echo "mail not sent";
                                    exit();
                            }
                            echo "User Registered successfully";
                            exit();
                                    // header("Location: ");

                        }
                        catch(Exception $e){
                            echo "There was an error on data while providing, kindly check";
                            exit();

                        }

                    }
                    else{
                        echo "Staff certificate should be pdf/doc/docx format only.";
                        exit();

                    };
                        
                };
            }
           

        };

    };

?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        <title>Document</title>

        <style>
            body{
                margin:0;
                padding:0;
                font-family:"Google Sans",sans-serif;
                background:#f5f5f5;
                display:flex;
                justify-content:center;
                align-items:center;
                min-height:100vh;
            }

            form{
                width:400px;
                background:white;
                padding:20px;
                border-radius:12px;
                border:2px solid rgb(28,122,173);
                box-shadow:0 10px 25px rgba(0,0,0,.1);
            }

            form::before{
                content:"Register";
                display:block;
                text-align:center;
                font-size:28px;
                font-weight:bold;
                color:rgb(28,122,173);
                margin-bottom:25px;
            }

            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="file"],
            select{
                width:100%;
                box-sizing:border-box;
                padding:9px;
                margin-bottom:15px;
                border:1px solid rgb(28,122,173);
                border-radius:6px;
                outline:none;
                background:white;
            }

            input[type="text"]:focus,
            input[type="email"]:focus,
            select:focus{
                border-color:rgb(28,122,173);
                box-shadow:0 0 5px rgba(28,122,173,.4);
            }

            #dept{
                cursor:pointer;
            }

            .radio-group{
                display:flex;
                gap:20px;
                margin-bottom:15px;
            }

            .designation{
                margin-right:5px;
            }

            label{
                color:#333;
                font-size:15px;
            }

            input[type="submit"]{
                width:100%;
                padding:9px;
                border: 1px solid;
                border-radius:6px;
                background:rgb(28,122,173);
                color:white;
                font-weight:bold;
                cursor:pointer;
                transition:.3s;
            }

            input[type="submit"]:hover{
                background:white;
                color:rgb(28,122,173);
                border-color:rgb(28,122,173);

                /* border:1px solid rgb(28,122,173); */
            }

            p{
                text-align:center;
                font-size:13px;
                margin:12px 0;
            }

            a{
                text-decoration:none;
                color:rgb(28,122,173);
            }

            #fb-button,
            #g-button{
                width:100%;
                padding:9px;
                border-radius:6px;
                border:1px solid rgb(28,122,173);
                background:white;
                color:rgb(28,122,173);
                font-weight:bold;
                cursor:pointer;
                margin-top:10px;

                display:flex;
                justify-content:center;
                align-items:center;
                gap:10px;

                transition:.3s;
            }

            #fb-button:hover,
            #g-button:hover{
                background:rgb(28,122,173);
                color:white;
            }

            #extra_field{
                margin-bottom:15px;
            }

            .fa-facebook,
            .fa-google{
                font-size:16px;
            }
            .password-container{
                position:relative;
                width:100%;
                margin-bottom:15px;
            }

            .password-container input{
                width:100%;
                padding:9px;
                padding-right:40px; 
                box-sizing:border-box;
                border:1px solid rgb(28,122,173);
                border-radius:6px;
                outline:none;
            }

            #eye{
                position:absolute;
                right:12px;
                top:40%;
                transform:translateY(-50%);
                cursor:pointer;
                color:gray;
            }
        </style>
    </head>
 

    <body>
        <form>

            <input type="text" name="name" placeholder="Please enter your name" required>
            <input type="text" name="email" placeholder="Please enter your email" required>
            <input type="radio" name="designation" class="designation" value="Staff" required>Staff
            <input type="radio" name="designation" class="designation" value="Student" required>Student
            <div id="extra_field"></div>
           
            <select name="dept" id="dept">
                <?php
                    while($data = $get->fetch_assoc()){
                ?>
                <option value="<?php echo $data['Dept'] ?>"><?php echo $data['Dept'] ?></option>
                <?php } ?>

            </select>
            
            <input type="text" name="Phone" placeholder="Please enter your Phone number" required>
            <input type="file" name="address" placeholder="Provide Aadhar for address proof" required>
            
            <div class="password-container">
                <input type="password" class="form-input" id="password" name="password" placeholder="Please enter your password" required>
                <i id="eye" class="fa-solid fa-eye-slash eye"></i>
            </div>

            <input type="submit" name="create">

            <p>Already have an account? <a href="index.html" target="_self">Login</a></p>
            <p>Or</p>
            <div>
                <button type="button" id="fb-button">
                    <i class="fa-brands fa-facebook"></i>
                    Login with Facebook
                </button>

                <button type="button" id="g-button">
                    <i class="fa-brands fa-google"></i>
                    Login with Google
                </button>            
        </div>

        </form>



        <script src="assets/scripts/jquery-4.0.0.min.js"></script>

        <script src="assets/scripts/register.js"></script>

    </body>

    

</html>