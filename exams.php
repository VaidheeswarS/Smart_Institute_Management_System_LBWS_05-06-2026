
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
    <div id="exam">
        <form id="exam-form">

            <div id="exam-bar">
                <h2>Exams</h2>
                <ul>
                    <li><input type="submit" name="Add" id="Add" value="Add Exam"></li>
                    <li><input type="submit" name="Delete" id="Delete" value="Delete Exam"></li>
                    <li><input type="submit" name="Update" id="Update" value="Update Exam"></li>
                </ul>
            </div>

            <div id="exams-list">
              
                <?php 
                    if($get->num_rows<=0){
                ?>
                    <td colspan=3>No exams found</td>
                <?php
                    }
                    else{
                        while($data = $get->fetch_assoc()){

                    
                ?>
                
                <div class="exam">
                    <td><h3 class="sub"><?php echo $data['sub'] ?> </h3></td>
                    <td><p class="exam"><?php echo $data['exam'] ?> </p></td>
                    <td><p class="date"><?php echo $data['date'] ?> </p></td>
                </div>
                
                <?php }} ?>
                <!-- loop cus -->
            </div>        
        </form>
</div>