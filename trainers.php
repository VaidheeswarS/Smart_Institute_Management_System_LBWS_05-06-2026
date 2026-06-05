
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
    $staff = $_SESSION['username'];

    $stmt = $conn->prepare("SELECT * FROM users where email=?");
    $stmt->bind_param("s",$staff);
    $stmt->execute();

    $get = $stmt->get_result();
    $result = $get->fetch_assoc();


    $stmt = $conn->prepare("SELECT * FROM users WHERE designation=?");
    $position = "Staff";
    $stmt->bind_param("s", $position);
    $stmt->execute();
    
    $get = $stmt->get_result();

?>
    <div id="trainer">
    <form id="staff-form">
        <input type="hidden" name="csrf" id="csrf" value="<?php echo $_SESSION['csrf_token'] ?>">
        
        <table>
        <?php
           if($result['designation']=="Staff"){

        ?>
            <tr>
                <th>Name</th>
                <th>Designation</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Certificate</th>
                <th>Aadhar</th>
                <th>Status</th>
            </tr>
            <?php
                    // $data = $get->fetch_assoc();
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
            <tr class="row">

                <td class="name"><?php echo $data['name'] ?></td>
                <td class="designation"><?php echo $data['designation'] ?></td>
                <td class="email"><?php echo $data['email'] ?></td>
                <td class="phone"><?php echo $data['phone'] ?></td>
                <td class="staff_certificate"><?php echo $data['staff_certificate'] ?></td>
                <td class="aadhar"><?php echo $data['aadhar'] ?></td>

               
                <td><input type="text" name="status" class="status" value=" <?php 
                    if($data['user_status']==1){
                        echo "Active";
                    }
                    else{
                        echo "In-Active";
                    }
                ?>" readonly></td>                
            </tr>
            <?php }} ?>
        <?php
           } 
           else{
        ?>
            <tr>
                <th>Name</th>
                <th>Designation</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Certificate</th>
                <th>Aadhar</th>
                <th>Status</th>
                <th>Delete Staff Account</th>
            </tr>
            <?php
                // $data = $get->fetch_assoc();
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
            <tr class="row">

                <td class="name"><?php echo $data['name'] ?></td>
                <td class="designation"><?php echo $data['designation'] ?></td>
                <td class="email"><?php echo $data['email'] ?></td>
                <td class="phone"><?php echo $data['phone'] ?></td>
                <td class="staff_certificate"><?php echo $data['staff_certificate'] ?></td>
                <td class="aadhar"><?php echo $data['aadhar'] ?></td>

               
                <td><input type="submit" name="status" class="status" value=" <?php
                    if($data['user_status']==1){
                        echo "Deactivate";
                    }
                    else{
                        echo "Activate";
                    }
                ?>"></td>
                
                <td><input type="submit" name="delete" class="delete" value="Delete Staff account"></td>
            </tr>
            <?php } }}?>
            
        </table>



    </form>
    </div>
