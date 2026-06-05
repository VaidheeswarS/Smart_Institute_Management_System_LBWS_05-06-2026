
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

    $stmt = $conn->prepare("SELECT * from Department");
    $stmt->execute();

    $get = $stmt->get_result();


?>
    <div id="c-u">
        <form id="course-form">


            <div id="courses-list">
                <?php
                    while($data = $get->fetch_assoc()){

                    
                ?>
                
                <div class="course">
                    <input type="hidden" name="csrf" class="csrf" value="<?php echo $_SESSION['csrf_token'] ?>">
                    <h3 class="c-dept"><?php echo $data['Dept'] ?> </h3>
                    <p class="c-about"><?php echo $data['about'] ?> </p>

                    <input  type="submit" name="course-detail" class="course-detail" value="View details" style="text-align: center">

                </div>
                
                <?php } ?>
                <!-- loop cus -->
            </div>        
        </form>
</div>