
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

    if($_SERVER['REQUEST_METHOD']=="POST"){

        $value = json_decode(file_get_contents("php://input"),true);
        if ($value['token']==$_SESSION['csrf_token']){

            $stmt = $conn->prepare("SELECT * from users where email = ?");
            $stmt->bind_param("s",$_SESSION['username']);
            $stmt->execute();

            $get = $stmt->get_result();
            $data = $get->fetch_assoc();


            if(password_verify($value['old_password'], $data['password'])){
                
                if($value['new_password'] == $value['confirm_password']){

                    $hash = password_hash($value['new_password'], PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE users SET password = ? where id=?");
                    $stmt->bind_param("si", $hash, $data['id']);
                    $stmt->execute();
                    echo json_encode([
                        "success" => true,
                        "message" => "password updated",
                        "userposition"=>$data['designation']
                    ]);

                }
                else{
                    echo json_encode([
                        "success" => false,
                        "message" => "New and confirm password are not matching."
                    ]);
                };
            }
            else{
                echo json_encode([
                    "success" => false,
                    "message" => "Password wrong"
                ]);
            };
        };

        
    }

?>
