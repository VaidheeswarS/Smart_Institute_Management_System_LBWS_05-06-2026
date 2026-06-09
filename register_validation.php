
<?php

    include("db.php");
    
    $stmt = $conn->prepare("SELECT * from Department");
    $stmt->execute();

    $get = $stmt->get_result();

?>


<?php
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $count = 0;
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $designation = htmlspecialchars($_POST['designation']);
        $dept = htmlspecialchars($_POST['dept']);
        $phone = htmlspecialchars($_POST['Phone']);
        $password = htmlspecialchars($_POST['pwd']);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $org_add = $_FILES['address']['name'];
        $temp_add =$_FILES['address']['tmp_name'];

        $add_filetype = strtolower(pathinfo($org_add, PATHINFO_EXTENSION));
        if($add_filetype!="pdf"){
            echo json_encode([
                "success"=>false,
                "message"=>"for Aadhar only pdf file is allowed."
            ]);
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
                    echo json_encode([
                        "success"=>false,
                        "message"=>"Email id already exists."
                    ]);
                    exit();
                }
            }

            if($count==0){
                if($designation!=="Staff"){
                    $query = "insert into users(name, email, designation, phone, password, aadhar, user_department) values('$name','$email', '$designation', '$phone', '$hashed_password', '$org_add','$dept_id')";
                    try{
                        mysqli_query($conn, $query);
                        echo json_encode([
                            "success"=>true,
                            "message"=>"User Register Successfully"
                        ]);
                        exit();
                                    // header("Location: ");
                    }
                    catch(Exception $e){
                        echo json_encode([
                            "success"=>false,
                            "message"=>"There was an error on data while providing, kindly check."
                        ]);
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
                            echo json_encode([
                                "success"=>true,
                                "message"=>"User Register Successfully"
                            ]);
                            exit();
                                    // header("Location: ");

                        }
                        catch(Exception $e){
                            echo json_encode([
                                "success"=>false,
                                "message"=>"There was an error on data while providing, kindly check."
                            ]);    
                            exit();

                        }

                    }
                    else{
                        echo json_encode([
                            "success"=>false,
                            "message"=>"Staff certificate should be pdf/doc/docx format only."
                        ]);   
                        exit();

                    };
                        
                };
            }
           

        };

    };

?>

