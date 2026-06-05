
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
    $data = json_decode(file_get_contents("php://input"),true);
    if($data['token']==$_SESSION['csrf_token']){
        
        $stmt = $conn->prepare("Insert into Department(Dept, about, duration, fees) values(?,?,?,?)");
        $stmt->bind_param("ssss", $data['name'], $data['about'], $data['duration'],$data['fees']);
        $stmt->execute();

        echo json_encode([
            "success"=> true,
            "message"=>"Added new course",
        ]);
        exit();
    }
    else{
        echo json_encode([

            "success"=>false,
            "message"=>"Unable to add course",
        ]);
        exit();
    }
}

?>

<div id="add-c">
<form id="add_course_form">
    <input type="hidden" name="csrf" id="csrf" value="<?php echo $_SESSION['csrf_token'] ?>">
    <input type="text" name="name" id="course-name" placeholder="Enter a Course name">
    <input type="text" name="about" id="course-about" placeholder="Enter Course Description">
    <input type="text" name="duration" id="course-duration" placeholder="Enter Course duration">
    <input type="text" name="fees" id="course-fees" placeholder="Enter Course Fees">

    <div id=btn>   
        <input type="submit" value="Add Course">
        <input type="button" id="back" value="Back">

    </div>
</form>
</div>