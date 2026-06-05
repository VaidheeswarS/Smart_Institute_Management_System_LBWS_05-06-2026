
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


    
    $stmt = $conn->prepare("SELECT * from exams");
    $stmt->execute();

    $get = $stmt->get_result();


?>

<div id="my-exam">
        <form id="exam-form">

            <div id="exams-list">
                <?php 
                    if($get->num_rows<=0){
                ?>
                    <p>No rows found</p>
                <?php
                    }
                    else{
                        while($data = $get->fetch_assoc()){

                    
                ?>
                
                <div class="exam">
                    <h3 class="sub"><?php echo $data['sub'] ?> </h3>
                    <p class="exam"><?php echo $data['exam'] ?> </p>
                    <p class="date"><?php echo $data['date'] ?> </p>

                </div>
                
                <?php }} ?>
                <!-- loop cus -->
            </div>        
        </form>
</div>

