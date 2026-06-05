
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


if($_SERVER["REQUEST_METHOD"]=="POST"){

   if($_POST['csrf']==$_SESSION['csrf_token']){

        $uname = $_POST['uname'];
        $uemail = $_POST['uemail'];
        $uphone = $_POST['uphone'];
        $oldaadhar = $_POST['oldaadhar'];

        $newaadhar = $_FILES['uaadhar']['name'];
        $temp_name = $_FILES['uaadhar']['tmp_name'];

        $email = $_SESSION['username'];

        if ($newaadhar==null || $newaadhar==""){
            $query= "update users SET name='$uname', email='$email', phone ='$phone', aadhar='$oldaadhar'";
            mysqli_query($conn, $query);
            //js

        }
        else{
            $FILE_TYPE= strtolower(pathinfo($newaadhar, PATHINFO_EXTENSION));

            if($FILE_TYPE!="pdf"){
                // js
            }
            else{
                move_uploaded_file($temp_name, "uploads/".$newaadhar);
                $query= "update users SET name='$uname', email='$email', phone ='$phone', aadhar='$newaadhar'";
                mysqli_query($conn, $query);
                // 
            }
        }


   }
   else{
    echo//js
   }
}
?>


