
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
    <div id="course">
        <form id="course-form">

            <div id="cou-bar">
                <h2>Courses</h2>
                <ul>
                    <li><input type="submit" name="Add" id="Add" value="Add Course"></li>
                    <li><input type="submit" name="Delete" id="Delete" value="Delete Course"></li>
                    <li><input type="submit" name="Update" id="Update" value="Update Course"></li>
                </ul>
            </div>

            <div id="courses-list">
                <?php
                    $count = $get->num_rows;
                    if($count<=0){
                        ?>
                        <tr>
                            <td colspan=8> No results</td>
                        </tr>
                        <?php
                    }
                    else{
                        while($data = $get->fetch_assoc()){

                    
                ?>
                
                <div class="course">
                    <input type="hidden" name="csrf" class="csrf" value="<?php echo $_SESSION['csrf_token'] ?>">
                    <h3 class="c-dept"><?php echo $data['Dept'] ?> </h3>
                    <p class="c-about"><?php echo $data['about'] ?> </p>

                    <input type="submit" name="course-detail" class="course-detail" value="View details">

                </div>
                
                <?php }} ?>
                <!-- loop cus -->
            </div>        
        </form>
    </div>